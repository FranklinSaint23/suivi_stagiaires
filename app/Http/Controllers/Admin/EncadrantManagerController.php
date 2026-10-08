<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EncadrantManagerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $encadrants = User::where('role', 'encadrant')
            ->when($search, function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('admin.encadrants.index', compact('encadrants', 'search'));
    }

    public function create()
    {
        return view('admin.encadrants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:30',
            'matricule' => 'nullable|string|max:50|unique:users,matricule',
            'password'  => 'required|string|min:6',
        ]);

        if (empty($data['matricule'])) {
            $data['matricule'] = 'ENC' . date('Y') . str_pad(User::where('role', 'encadrant')->count() + 1, 4, '0', STR_PAD_LEFT);
        }

        $plainPassword    = $data['password'];
        $data['password'] = Hash::make($plainPassword);
        $data['role']     = 'encadrant';

        $encadrant = User::create($data);

        $waLink = !empty($encadrant->telephone)
            ? \App\Helpers\WhatsAppHelper::encadrantCredentialsLink($encadrant->telephone, $encadrant->nom, $encadrant->matricule, $encadrant->email, $plainPassword)
            : null;

        return redirect()->route('admin.encadrants.index')
            ->with('success', "Encadrant {$encadrant->nom} créé avec succès (Matricule: {$encadrant->matricule}).")
            ->with('whatsapp_link', $waLink)
            ->with('encadrant_nom', $encadrant->nom);
    }

    public function edit(User $encadrant)
    {
        abort_unless($encadrant->role === 'encadrant', 404);
        return view('admin.encadrants.edit', compact('encadrant'));
    }

    public function update(Request $request, User $encadrant)
    {
        abort_unless($encadrant->role === 'encadrant', 404);

        $data = $request->validate([
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $encadrant->id,
            'telephone' => 'nullable|string|max:30',
            'matricule' => 'required|string|max:50|unique:users,matricule,' . $encadrant->id,
            'password'  => 'nullable|string|min:6',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $encadrant->update($data);

        return redirect()->route('admin.encadrants.index')
            ->with('success', 'Informations de l\'encadrant mises à jour.');
    }

    public function destroy(User $encadrant)
    {
        abort_unless($encadrant->role === 'encadrant', 404);
        $encadrant->delete();

        return redirect()->route('admin.encadrants.index')
            ->with('success', 'Encadrant supprimé avec succès.');
    }

    public function resetPassword(User $encadrant)
    {
        abort_unless($encadrant->role === 'encadrant', 404);
        $tempPassword = Str::random(8);
        $encadrant->update(['password' => Hash::make($tempPassword)]);

        $waLink = !empty($encadrant->telephone)
            ? \App\Helpers\WhatsAppHelper::messageLink($encadrant->telephone, "Bonjour {$encadrant->nom}, votre mot de passe Encadrant StageTrack a été réinitialisé.\nMatricule : {$encadrant->matricule}\nEmail : {$encadrant->email}\nNouveau mot de passe : {$tempPassword}\nLien de connexion : " . url('/login'))
            : null;

        return back()->with([
            'reset_user'    => $encadrant->nom . ' (' . $encadrant->matricule . ')',
            'temp_password' => $tempPassword,
            'whatsapp_link' => $waLink,
        ]);
    }

}
