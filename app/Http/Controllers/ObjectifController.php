<?php

namespace App\Models;
namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Stagiaire;
use App\Models\AppNotification;
use Illuminate\Http\Request;

class ObjectifController extends Controller
{
    public function index(Request $request)
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        $query = Objectif::with(['stagiaire', 'stage']);

        if ($request->filled('stagiaire_id')) {
            $query->where('stagiaire_id', $request->stagiaire_id);
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $objectifs = $query->latest()->get();

        return view('encadrant.objectifs.index', compact('objectifs', 'stagiaires'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'date_limite'  => 'nullable|date',
        ]);

        $stagiaire = Stagiaire::findOrFail($data['stagiaire_id']);
        $latestStage = $stagiaire->stages()->latest()->first();
        if ($latestStage) {
            $data['stage_id'] = $latestStage->id;
        }

        $objectif = Objectif::create($data);

        // Send notification to stagiaire if user exists
        $user = \App\Models\User::where('email', $stagiaire->email)->first();
        if ($user) {
            AppNotification::create([
                'user_id' => $user->id,
                'titre'   => 'Nouvel objectif assigné',
                'message' => "Un nouvel objectif vous a été assigné : {$objectif->titre}",
                'type'    => 'info',
                'lien'    => route('stagiaire.dashboard'),
            ]);
        }

        return redirect()->back()->with('success', 'Objectif assigné avec succès au stagiaire.');
    }

    public function updateStatut(Request $request, Objectif $objectif)
    {
        $data = $request->validate([
            'statut' => 'required|in:À faire,En cours,Terminé',
        ]);

        $objectif->update(['statut' => $data['statut']]);

        return redirect()->back()->with('success', 'Statut de l\'objectif mis à jour.');
    }

    public function destroy(Objectif $objectif)
    {
        $objectif->delete();
        return redirect()->back()->with('success', 'Objectif supprimé.');
    }
}
