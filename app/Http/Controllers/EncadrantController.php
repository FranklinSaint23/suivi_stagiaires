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
        $demandes           = DemandeStage::latest()->get();
        $stagiaires         = Stagiaire::with(['presences', 'objectifs', 'rapports'])->orderBy('nom')->get();
        $rapportsEnAttente  = RapportPeriodique::where('statut', 'Soumis')->with('stagiaire')->latest()->get();
        $objectifsEnRetard  = Objectif::where('statut', '!=', 'Terminé')->where('date_limite', '<', now())->with('stagiaire')->get();

        // Stagiaires needing intervention (progression < 60%, presence < 75%, or pending reports)
        $stagiairesIntervention = $stagiaires->filter(function ($s) {
            return $s->progression_globale < 60 || $s->taux_presence < 75 || $s->rapports->where('statut', 'Soumis')->count() > 0;
        });

        return view('encadrant.dashboard', compact(
            'demandes', 'stagiaires', 'rapportsEnAttente', 'objectifsEnRetard', 'stagiairesIntervention'
        ));
    }
}
