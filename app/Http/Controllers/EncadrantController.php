<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use App\Models\Stagiaire;
use App\Models\RapportPeriodique;
use App\Models\Objectif;

class EncadrantController extends Controller
{
    public function dashboard()
    {
        $encadrantId = auth()->id();

        $demandes = DemandeStage::where(function ($q) use ($encadrantId) {
            $q->where('etat', 'En attente')
              ->orWhere('encadrant_id', $encadrantId);
        })->latest()->get();

        $stagiaires = Stagiaire::where('encadrant_id', $encadrantId)
            ->with(['presences', 'objectifs', 'rapports'])
            ->orderBy('nom')
            ->get();

        $rapportsEnAttente = RapportPeriodique::where('statut', 'Soumis')
            ->whereHas('stagiaire', fn($q) => $q->where('encadrant_id', $encadrantId))
            ->with('stagiaire')
            ->latest()
            ->get();

        $objectifsEnRetard = Objectif::where('statut', '!=', 'Terminé')
            ->where('date_limite', '<', now())
            ->whereHas('stagiaire', fn($q) => $q->where('encadrant_id', $encadrantId))
            ->with('stagiaire')
            ->get();

        // Stagiaires needing intervention (progression < 60%, presence < 75%, or pending reports)
        $stagiairesIntervention = $stagiaires->filter(function ($s) {
            return $s->progression_globale < 60 || $s->taux_presence < 75 || $s->rapports->where('statut', 'Soumis')->count() > 0;
        });

        return view('encadrant.dashboard', compact(
            'demandes', 'stagiaires', 'rapportsEnAttente', 'objectifsEnRetard', 'stagiairesIntervention'
        ));
    }
}
