<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'email'         => 'required|email|unique:stagiaires,email|unique:users,email',
            'password'      => 'nullable|string|min:4',
            'photo'         => 'nullable|image|max:4096',
            'lieu'          => 'nullable|string|max:255',
            'filiere'       => 'nullable|string|max:100',
        ], [
            'nom.required'      => 'Le nom est obligatoire.',
            'prenom.required'   => 'Le prénom est obligatoire.',
            'email.required'    => 'L\'adresse email est obligatoire.',
            'email.unique'      => 'Cette adresse email est déjà utilisée par un autre stagiaire ou compte.',
            'email.email'       => 'Veuillez fournir une adresse email valide.',
            'sexe.required'     => 'Veuillez sélectionner le sexe.',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        $plainPassword    = !empty($data['password']) ? $data['password'] : 'stagiaire123';
        $data['password'] = bcrypt($plainPassword);

        DB::transaction(function () use ($data, $plainPassword) {
            $stagiaire = Stagiaire::create($data);

            $year      = date('Y');
            $matricule = 'STG' . $year . str_pad($stagiaire->id, 4, '0', STR_PAD_LEFT);

            User::create([
                'nom'       => $stagiaire->prenom . ' ' . $stagiaire->nom,
                'matricule' => $matricule,
                'email'     => $stagiaire->email,
                'password'  => bcrypt($plainPassword),
                'role'      => 'stagiaire',
            ]);
        });

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

        $oldEmail = $stagiaire->email;

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        DB::transaction(function () use ($stagiaire, $data, $oldEmail) {
            $stagiaire->update($data);

            $user = User::where('email', $oldEmail)->first();
            if ($user) {
                $userUpdate = [
                    'nom'   => $stagiaire->prenom . ' ' . $stagiaire->nom,
                    'email' => $stagiaire->email,
                ];
                if (isset($data['password'])) {
                    $userUpdate['password'] = $data['password'];
                }
                $user->update($userUpdate);
            }
        });

        return redirect()->route('encadrant.stagiaires.index')
            ->with('success', 'Stagiaire modifié avec succès.');
    }

    public function destroy(Stagiaire $stagiaire)
    {
        DB::transaction(function () use ($stagiaire) {
            if ($stagiaire->photo) {
                Storage::disk('public')->delete($stagiaire->photo);
            }
            User::where('email', $stagiaire->email)->delete();
            $stagiaire->delete();
        });

        return redirect()->route('encadrant.stagiaires.index')
            ->with('success', 'Stagiaire supprimé.');
    }
}
