<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index(Request $request)
    {
        $mois  = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        $stagiaires = Stagiaire::orderBy('nom')->get();

        $presencesMap = [];
        foreach ($stagiaires as $s) {
            $rows = Presence::where('stagiaire_id', $s->id)
                ->whereMonth('date', $mois)
                ->whereYear('date', $annee)
                ->get()
                ->keyBy(fn($p) => $p->date->format('Y-m-d'));
            $presencesMap[$s->id] = $rows;
        }

        $nbJours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

        return view('encadrant.presences.index', compact(
            'stagiaires', 'presencesMap', 'mois', 'annee', 'nbJours'
        ));
    }

    public function create()
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        return view('encadrant.presences.create', compact('stagiaires'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'date'         => 'required|date',
            'present'      => 'required|boolean',
        ]);

        $data['statut'] = $data['present'] ? 'Présent' : 'Absent';

        Presence::updateOrCreate(
            ['stagiaire_id' => $data['stagiaire_id'], 'date' => $data['date']],
            ['present' => $data['present'], 'statut' => $data['statut']]
        );

        return redirect()->route('encadrant.presences.create')
            ->with('success', 'Présence enregistrée.');
    }
}
