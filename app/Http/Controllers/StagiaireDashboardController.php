<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Message;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class StagiaireDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $stagiaire = Stagiaire::where('email', $user->email)->first();

        $mois  = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        $presences = [];
        $messages  = [];

        if ($stagiaire) {
            $presences = Presence::where('stagiaire_id', $stagiaire->id)
                ->whereMonth('date', $mois)
                ->whereYear('date', $annee)
                ->orderBy('date')
                ->get()
                ->keyBy(fn($p) => $p->date->format('Y-m-d'));

            $messages = Message::where('stagiaire_id', $stagiaire->id)
                ->with('reponses')
                ->latest()
                ->get();
        }

        return view('stagiaire.dashboard', compact('stagiaire', 'presences', 'messages', 'mois', 'annee'));
    }
}
