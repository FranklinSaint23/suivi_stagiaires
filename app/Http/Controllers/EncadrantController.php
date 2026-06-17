<?php

namespace App\Http\Controllers;

use App\Models\DemandeStage;
use App\Models\Stagiaire;

class EncadrantController extends Controller
{
    public function dashboard()
    {
        $demandes   = DemandeStage::latest()->get();
        $stagiaires = Stagiaire::orderBy('nom')->get();

        return view('encadrant.dashboard', compact('demandes', 'stagiaires'));
    }
}
