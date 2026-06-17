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
            return response()->json(['error' => 'Aucun CV disponible pour cette demande.'], 422);
        }

        $path = Storage::disk('public')->path($demande->cv);

        if (!file_exists($path)) {
            return response()->json(['error' => 'Fichier CV introuvable sur le serveur.'], 404);
        }

        try {
            $parser = new PdfParser();
            $cvText = $parser->parseFile($path)->getText();

            if (strlen(trim($cvText)) < 50) {
                return response()->json(['error' => 'PDF scanné sans texte extractible. Utilisez un PDF texte.'], 422);
            }

            $result = $this->ai->analyseCv($cvText, $demande->prenom . ' ' . $demande->nom, $demande->filiere);
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function rapportPerformance(Stagiaire $stagiaire)
    {
        try {
            $total    = $stagiaire->presences->count();
            $presents = $stagiaire->presences->where('present', true)->count();

            $stages = $stagiaire->stages->map(fn($s) => [
                'theme'         => $s->theme,
                'etablissement' => $s->etablissement,
            ])->toArray();

            $result = $this->ai->rapportPerformance(
                $stagiaire->toArray(),
                $stagiaire->taux_presence,
                $total - $presents,
                $stages
            );

            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
                return response()->json(['result' => 'Aucun stagiaire enregistré pour l\'analyse.']);
            }

            $result = $this->ai->detecterAnomalies($data);
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
