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

    private function resolveFilePath(?string $storedPath): ?string
    {
        if (!$storedPath) return null;
        $cleanPath = ltrim(str_replace(['storage/', 'public/'], '', str_replace('\\', '/', $storedPath)), '/');
        $filename  = basename($cleanPath);
        $possiblePaths = [
            storage_path('app/public/' . $cleanPath),
            storage_path('app/public/uploads/' . $filename),
            storage_path('app/' . $cleanPath),
            storage_path('app/uploads/' . $filename),
            public_path('storage/' . $cleanPath),
            public_path('storage/uploads/' . $filename),
            public_path('uploads/' . $filename),
            public_path($cleanPath),
        ];

        foreach ($possiblePaths as $p) {
            if (!empty($p) && file_exists($p) && is_file($p)) {
                return $p;
            }
        }
        return null;
    }

    public function analyseCv(DemandeStage $demande)
    {
        if (!$demande->cv) {
            return response()->json(['error' => 'Aucun CV disponible pour cette demande.'], 422);
        }

        $path = $this->resolveFilePath($demande->cv);

        if (!$path) {
            return response()->json(['error' => 'Fichier CV introuvable sur le serveur. Veuillez ré-uploader le document.'], 404);
        }

        try {
            $parser = new PdfParser();
            $cvText = '';
            try {
                $cvText = $parser->parseFile($path)->getText();
            } catch (\Throwable $e) {
                // PDF non analysable directement par le parser
                $cvText = '';
            }

            // Vérifier si la lettre de motivation a du texte
            $lettreText = '';
            if ($demande->lettre) {
                $lettrePath = $this->resolveFilePath($demande->lettre);
                if ($lettrePath) {
                    try {
                        $lettreText = $parser->parseFile($lettrePath)->getText();
                    } catch (\Throwable $e) {}
                }
            }

            if (strlen(trim($cvText)) >= 50) {
                // PDF texte classique
                $result = $this->ai->analyseCv($cvText, $demande->prenom . ' ' . $demande->nom, $demande->filiere);
            } else {
                // CV image scannée (CamScanner, etc.)
                $demandeData = [
                    'nom'        => $demande->nom,
                    'prenom'     => $demande->prenom,
                    'sexe'       => $demande->sexe === 'F' ? 'Féminin' : 'Masculin',
                    'filiere'    => $demande->filiere,
                    'lieu'       => $demande->lieu,
                    'email'      => $demande->email,
                    'telephone'  => $demande->telephone,
                    'date_debut' => optional($demande->date_debut)->format('d/m/Y') ?? 'Non précisée',
                    'date_fin'   => optional($demande->date_fin)->format('d/m/Y') ?? 'Non précisée',
                ];

                $aiResult = $this->ai->analyseDossierCandidat($demandeData, trim($lettreText));
                $notice = "📄 **Note sur le document** : Le CV fourni est une numérisation/scan d'image (ex: CamScanner sans couche de texte sélectionnable).\n"
                    . "L'évaluation a été réalisée à partir des données académiques du dossier" . (strlen(trim($lettreText)) >= 50 ? " et de la lettre de motivation jointe" : "") . " :\n\n---\n\n";
                $result = $notice . $aiResult;
            }

            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function rapportPerformance(Stagiaire $stagiaire)
    {
        abort_if($stagiaire->encadrant_id && $stagiaire->encadrant_id !== auth()->id(), 403);

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
            $query = Stagiaire::with('presences');
            if (auth()->check() && auth()->user()->role === 'encadrant') {
                $query->where('encadrant_id', auth()->id());
            }

            $data = $query->get()->map(function ($s) {
                $total    = $s->presences->count();
                $presents = $s->presences->where('present', true)->count();
                return [
                    'nom'      => $s->prenom . ' ' . $s->nom,
                    'taux'     => $total > 0 ? round(($presents / $total) * 100, 1) : 0,
                    'absences' => $total - $presents,
                ];
            })->toArray();

            if (empty($data)) {
                return response()->json(['result' => 'Aucun stagiaire dans votre portefeuille pour l\'analyse.']);
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
