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
        $data = $request->validate([
            'titre'   => 'required|string|max:255',
            'periode' => 'required|string',
            'contenu' => 'required|string|min:20',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $stagiaire = Stagiaire::where('email', auth()->user()->email)->firstOrFail();
        $latestStage = $stagiaire->stages()->latest()->first();

        $data['stagiaire_id'] = $stagiaire->id;
        $data['stage_id']     = $latestStage?->id;
        $data['statut']       = 'Soumis';

        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('uploads', 'public');
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
