<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StageController extends Controller
{
    public function index(Request $request)
    {
        $query = Stage::with('stagiaire');

        if ($request->filled('theme')) {
            $query->where('theme', 'like', '%' . $request->theme . '%');
        }
        if ($request->filled('stagiaire_id')) {
            $query->where('stagiaire_id', $request->stagiaire_id);
        }
        if ($request->filled('date')) {
            $query->where('date_debut', '<=', $request->date)
                  ->where('date_fin', '>=', $request->date);
        }

        $stages     = $query->latest()->get();
        $stagiaires = Stagiaire::orderBy('nom')->get();

        return view('encadrant.stages.index', compact('stages', 'stagiaires'));
    }

    public function create()
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        return view('encadrant.stages.create', compact('stagiaires'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stagiaire_id'  => 'required|exists:stagiaires,id',
            'date_debut'    => 'required|date',
            'date_fin'      => 'required|date|after_or_equal:date_debut',
            'etablissement' => 'required|string|max:255',
            'theme'         => 'required|string|max:255',
            'rapport'       => 'nullable|file|mimes:pdf|max:5120',
            'convention'    => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('rapport')) {
            $data['rapport'] = $request->file('rapport')->store('uploads', 'public');
        }
        if ($request->hasFile('convention')) {
            $data['convention'] = $request->file('convention')->store('uploads', 'public');
        }

        Stage::create($data);

        return redirect()->route('encadrant.stagiaires.show', $data['stagiaire_id'])
            ->with('success', 'Stage ajouté avec succès.');
    }

    public function edit(Stage $stage)
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        return view('encadrant.stages.edit', compact('stage', 'stagiaires'));
    }

    public function update(Request $request, Stage $stage)
    {
        $data = $request->validate([
            'stagiaire_id'  => 'required|exists:stagiaires,id',
            'date_debut'    => 'required|date',
            'date_fin'      => 'required|date|after_or_equal:date_debut',
            'etablissement' => 'required|string|max:255',
            'theme'         => 'required|string|max:255',
            'rapport'       => 'nullable|file|mimes:pdf|max:5120',
            'convention'    => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('rapport')) {
            if ($stage->rapport) Storage::disk('public')->delete($stage->rapport);
            $data['rapport'] = $request->file('rapport')->store('uploads', 'public');
        }
        if ($request->hasFile('convention')) {
            if ($stage->convention) Storage::disk('public')->delete($stage->convention);
            $data['convention'] = $request->file('convention')->store('uploads', 'public');
        }

        $stage->update($data);

        return redirect()->route('encadrant.stages.index')
            ->with('success', 'Stage modifié avec succès.');
    }

    public function destroy(Stage $stage)
    {
        if ($stage->rapport) Storage::disk('public')->delete($stage->rapport);
        if ($stage->convention) Storage::disk('public')->delete($stage->convention);
        $stage->delete();

        return redirect()->route('encadrant.stages.index')
            ->with('success', 'Stage supprimé.');
    }
}
