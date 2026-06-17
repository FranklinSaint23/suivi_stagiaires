<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StagiaireController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $stagiaires = Stagiaire::when($search, function ($q) use ($search) {
            $q->where('nom', 'like', "%$search%")
              ->orWhere('prenom', 'like', "%$search%");
        })->orderBy('nom')->get();

        return view('encadrant.stagiaires.index', compact('stagiaires', 'search'));
    }

    public function create()
    {
        return view('encadrant.stagiaires.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sexe'          => 'required|in:M,F',
            'nom'           => 'required|string|max:255',
            'prenom'        => 'required|string|max:255',
            'naissance'     => 'nullable|date',
            'lieu_naissance'=> 'nullable|string|max:255',
            'telephone'     => 'nullable|string|max:20',
            'email'         => 'required|email|unique:stagiaires,email',
            'password'      => 'required|string|min:6',
            'photo'         => 'nullable|image|max:2048',
            'lieu'          => 'nullable|string|max:255',
            'filiere'       => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        $data['password'] = bcrypt($data['password']);
        Stagiaire::create($data);

        return redirect()->route('encadrant.stagiaires.index')
            ->with('success', 'Stagiaire ajouté avec succès.');
    }

    public function show(Stagiaire $stagiaire)
    {
        $stagiaire->load('stages', 'presences');
        return view('encadrant.stagiaires.show', compact('stagiaire'));
    }

    public function edit(Stagiaire $stagiaire)
    {
        return view('encadrant.stagiaires.edit', compact('stagiaire'));
    }

    public function update(Request $request, Stagiaire $stagiaire)
    {
        $data = $request->validate([
            'sexe'          => 'required|in:M,F',
            'nom'           => 'required|string|max:255',
            'prenom'        => 'required|string|max:255',
            'naissance'     => 'nullable|date',
            'lieu_naissance'=> 'nullable|string|max:255',
            'telephone'     => 'nullable|string|max:20',
            'email'         => 'required|email|unique:stagiaires,email,' . $stagiaire->id,
            'password'      => 'nullable|string|min:6',
            'photo'         => 'nullable|image|max:2048',
            'lieu'          => 'nullable|string|max:255',
            'filiere'       => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('photo')) {
            if ($stagiaire->photo) Storage::disk('public')->delete($stagiaire->photo);
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $stagiaire->update($data);

        return redirect()->route('encadrant.stagiaires.index')
            ->with('success', 'Stagiaire modifié avec succès.');
    }

    public function destroy(Stagiaire $stagiaire)
    {
        if ($stagiaire->photo) {
            Storage::disk('public')->delete($stagiaire->photo);
        }
        $stagiaire->delete();

        return redirect()->route('encadrant.stagiaires.index')
            ->with('success', 'Stagiaire supprimé.');
    }
}
