<?php

namespace App\Http\Controllers;

use App\Models\RapportPeriodique;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\AppNotification;
use App\Services\GroqService;
use Illuminate\Http\Request;

class RapportPeriodiqueController extends Controller
{
    public function __construct(private GroqService $groq) {}

    // --- Encadrant Side ---
    public function indexEncadrant(Request $request)
    {
        $query = RapportPeriodique::with('stagiaire');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('stagiaire_id')) {
            $query->where('stagiaire_id', $request->stagiaire_id);
        }

        $rapports = $query->latest()->get();
        $stagiaires = Stagiaire::orderBy('nom')->get();

        return view('encadrant.rapports.index', compact('rapports', 'stagiaires'));
    }

    public function showEncadrant(RapportPeriodique $rapport)
    {
        $rapport->load(['stagiaire.objectifs', 'stage']);
        return view('encadrant.rapports.show', compact('rapport'));
    }

    public function validerEncadrant(Request $request, RapportPeriodique $rapport)
    {
        $data = $request->validate([
            'statut'                => 'required|in:Validé,Correction demandée',
            'commentaire_encadrant' => 'nullable|string',
        ]);

        $rapport->update([
            'statut'                => $data['statut'],
            'commentaire_encadrant' => $data['commentaire_encadrant'] ?? $rapport->commentaire_encadrant,
        ]);

        // Notify Stagiaire
        $user = User::where('email', $rapport->stagiaire->email)->first();
        if ($user) {
            $type = $data['statut'] === 'Validé' ? 'success' : 'warning';
            $msg  = $data['statut'] === 'Validé' 
                ? "Votre rapport '{$rapport->titre}' a été validé par votre encadrant."
                : "Des corrections ont été demandées sur votre rapport '{$rapport->titre}'.";

            AppNotification::create([
                'user_id' => $user->id,
                'titre'   => "Rapport {$data['statut']}",
                'message' => $msg,
                'type'    => $type,
                'lien'    => route('stagiaire.rapports.index'),
            ]);
        }

        return redirect()->back()->with('success', "Le rapport a été marqué comme '{$data['statut']}'.");
    }

    public function analyserIa(RapportPeriodique $rapport)
    {
        try {
            $result = $this->groq->analyseRapport(
                $rapport->contenu,
                $rapport->stagiaire->nom_complet,
                $rapport->stagiaire->filiere,
                $rapport->periode
            );

            $rapport->update(['analyse_ia' => $result]);

            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // --- Stagiaire Side ---
    public function indexStagiaire()
    {
        $stagiaire = Stagiaire::where('email', auth()->user()->email)->firstOrFail();
        $rapports  = $stagiaire->rapports()->latest()->get();

        return view('stagiaire.rapports.index', compact('stagiaire', 'rapports'));
    }

    public function createStagiaire()
    {
        $stagiaire = Stagiaire::where('email', auth()->user()->email)->firstOrFail();
        return view('stagiaire.rapports.create', compact('stagiaire'));
    }

    public function storeStagiaire(Request $request)
    {
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
            $err = $_FILES['fichier']['error'];
            if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
                return back()->withErrors(['fichier' => 'Le fichier téléversé dépasse la limite autorisée par le serveur web (Code PHP: UPLOAD_ERR_INI_SIZE). Veuillez choisir un fichier de moins de 10 Mo.'])->withInput();
            }
            return back()->withErrors(['fichier' => "Erreur de téléversement (Code PHP: $err). Veuillez réessayer."])->withInput();
        }

        $data = $request->validate([
            'titre'   => 'required|string|max:255',
            'periode' => 'required|string',
            'contenu' => 'required|string|min:20',
            'fichier' => 'nullable|file|max:10240',
        ], [
            'titre.required'   => 'Le titre du rapport est obligatoire.',
            'periode.required' => 'Veuillez sélectionner la période concernée.',
            'contenu.required' => 'Le compte-rendu doit contenir au moins 20 caractères.',
            'contenu.min'      => 'Le compte-rendu doit contenir au moins 20 caractères.',
            'fichier.max'      => 'La taille du document ne doit pas dépasser 10 Mo.',
        ]);

        $user = auth()->user();
        $stagiaire = Stagiaire::where('email', $user->email)->first();
        if (!$stagiaire) {
            $stagiaire = Stagiaire::where('nom', 'like', "%{$user->nom}%")->first();
        }
        if (!$stagiaire) {
            return back()->withErrors(['titre' => 'Profil stagiaire introuvable. Veuillez contacter l\'administration.'])->withInput();
        }

        $latestStage = $stagiaire->stages()->latest()->first();

        $data['stagiaire_id'] = $stagiaire->id;
        $data['stage_id']     = $latestStage?->id;
        $data['statut']       = 'Soumis';

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');

            if (!$file->isValid()) {
                return back()->withErrors(['fichier' => 'Le fichier n\'a pas pu être téléversé (erreur de transfert).'])->withInput();
            }

            $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
                return back()->withErrors(['fichier' => "Le format [.$ext] n'est pas autorisé. Seuls les fichiers PDF, DOC et DOCX sont acceptés."])->withInput();
            }

            $uploadDir = storage_path('app/public/uploads');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }

            $data['fichier'] = $file->store('uploads', 'public');
        }

        $rapport = RapportPeriodique::create($data);

        // Notify Encadrants
        $encadrants = User::where('role', 'encadrant')->get();
        foreach ($encadrants as $enc) {
            AppNotification::create([
                'user_id' => $enc->id,
                'titre'   => 'Nouveau rapport soumis',
                'message' => "Le stagiaire {$stagiaire->nom_complet} a soumis son rapport {$data['periode']} : {$rapport->titre}",
                'type'    => 'info',
                'lien'    => route('encadrant.rapports.show', $rapport),
            ]);
        }

        return redirect()->route('stagiaire.rapports.index')
            ->with('success', 'Votre rapport a été soumis avec succès.');
    }
}
