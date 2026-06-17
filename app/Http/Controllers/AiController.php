<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\DemandeStage;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class AiController extends Controller
{
    public function __construct(private GroqService $ai) {}

    public function analyseCv(DemandeStage $demande)
    {
        if (!$demande->cv) {
            return back()->with('ai_error', 'Aucun CV disponible pour cette demande.');
        }

        $path = Storage::disk('public')->path($demande->cv);

        if (!file_exists($path)) {
            return back()->with('ai_error', 'Fichier CV introuvable sur le serveur.');
        }

        try {
            $parser  = new PdfParser();
            $pdf     = $parser->parseFile($path);
            $cvText  = $pdf->getText();

            if (strlen(trim($cvText)) < 50) {
                return back()->with('ai_error', 'Le PDF semble être scanné (pas de texte extractible). Utilisez un PDF texte.');
            }

            $result = $this->ai->analyseCv($cvText, $demande->prenom . ' ' . $demande->nom, $demande->filiere);
            return back()->with('ai_cv_result', $result);
        } catch (\Exception $e) {
            return back()->with('ai_error', $e->getMessage());
        }
    }

    public function rapportPerformance(Stagiaire $stagiaire)
    {
        try {
            $total    = $stagiaire->presences->count();
            $presents = $stagiaire->presences->where('present', true)->count();
            $absences = $total - $presents;

            $stages = $stagiaire->stages->map(fn($s) => [
                'theme'         => $s->theme,
                'etablissement' => $s->etablissement,
            ])->toArray();

            $result = $this->ai->rapportPerformance(
                $stagiaire->toArray(),
                $stagiaire->taux_presence,
                $absences,
                $stages
            );

            return back()->with('ai_rapport', $result);
        } catch (\Exception $e) {
            return back()->with('ai_error', $e->getMessage());
        }
    }

    public function detecterAnomalies()
    {
        try {
            $data = Stagiaire::with('presences')->get()->map(function ($s) {
                $total    = $s->presences->count();
                $presents = $s->presences->where('present', true)->count();
                return [
                    'nom'      => $s->prenom . ' ' . $s->nom,
                    'taux'     => $total > 0 ? round(($presents / $total) * 100, 1) : 0,
                    'absences' => $total - $presents,
                ];
            })->toArray();

            if (empty($data)) {
                return back()->with('ai_anomalies', 'Aucun stagiaire enregistré pour l\'analyse.');
            }

            $result = $this->ai->detecterAnomalies($data);
            return back()->with('ai_anomalies', $result);
        } catch (\Exception $e) {
            return back()->with('ai_error', $e->getMessage());
        }
    }

    public function chatStagiaire(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|max:500',
            'historique' => 'nullable|array|max:10',
        ]);

        $stagiaire = Stagiaire::where('email', auth()->user()->email)->first();

        if (!$stagiaire) {
            return response()->json(['error' => 'Profil stagiaire introuvable.'], 404);
        }

        $contexte = [
            'prenom'        => $stagiaire->prenom,
            'nom'           => $stagiaire->nom,
            'filiere'       => $stagiaire->filiere,
            'taux_presence' => $stagiaire->taux_presence,
        ];

        try {
            $reponse = $this->ai->chatStagiaire(
                $request->input('message'),
                $contexte,
                $request->input('historique', [])
            );

            return response()->json(['reponse' => $reponse]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
