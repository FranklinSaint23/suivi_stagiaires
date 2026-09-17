<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StagiaireManagerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $stagiaires = Stagiaire::when($search, function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('filiere', 'like', "%{$search}%");
        })->orderBy('nom')->get();

        return view('admin.stagiaires.index', compact('stagiaires', 'search'));
    }

    public function create()
    {
        return view('admin.stagiaires.create');
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
            'password'      => 'required|string|min:6',
            'photo'         => 'nullable|image|max:2048',
            'lieu'          => 'nullable|string|max:255',
            'filiere'       => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        $plainPassword = $data['password'];
        $data['password'] = Hash::make($plainPassword);

        DB::transaction(function () use ($data, $plainPassword) {
            $stagiaire = Stagiaire::create($data);

            $year      = date('Y');
            $matricule = 'STG' . $year . str_pad($stagiaire->id, 4, '0', STR_PAD_LEFT);

            User::create([
                'nom'       => $stagiaire->prenom . ' ' . $stagiaire->nom,
                'matricule' => $matricule,
                'email'     => $stagiaire->email,
                'password'  => Hash::make($plainPassword),
                'role'      => 'stagiaire',
            ]);
        });

        return redirect()->route('admin.stagiaires.index')
            ->with('success', 'Stagiaire créé et compte utilisateur synchronisé avec succès.');
    }

    public function edit(Stagiaire $stagiaire)
    {
        return view('admin.stagiaires.edit', compact('stagiaire'));
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
            $data['password'] = Hash::make($data['password']);
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

        return redirect()->route('admin.stagiaires.index')
            ->with('success', 'Informations du stagiaire et compte utilisateur mis à jour.');
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

        return redirect()->route('admin.stagiaires.index')
            ->with('success', 'Stagiaire et son compte utilisateur supprimés.');
    }

    public function resetPassword(Stagiaire $stagiaire)
    {
        $tempPassword = Str::random(8);
        $hashed = Hash::make($tempPassword);

        DB::transaction(function () use ($stagiaire, $hashed) {
            $stagiaire->update(['password' => $hashed]);
            User::where('email', $stagiaire->email)->update(['password' => $hashed]);
        });

        return back()->with([
            'reset_user'    => $stagiaire->nom_complet,
            'temp_password' => $tempPassword,
            'user_phone'    => $stagiaire->telephone,
        ]);
    }
}
