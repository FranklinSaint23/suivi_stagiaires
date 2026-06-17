<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsAppHelper;
use App\Models\DemandeStage;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DemandeStageController extends Controller
{
    public function publicForm()
    {
        return view('demande.form');
    }

    public function publicStore(Request $request)
    {
        $data = $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'email'      => 'required|email',
            'sexe'       => 'required|in:M,F',
            'photo'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'lieu'       => 'required|string|max:255',
            'filiere'    => 'required|string|max:100',
            'telephone'  => 'required|string|max:20',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
            'cv'         => 'required|file|mimes:pdf|max:5120',
            'lettre'     => 'required|file|mimes:pdf|max:5120',
            'certificat' => 'required|file|mimes:pdf|max:5120',
        ]);

        $data['photo']      = $request->file('photo')->store('uploads', 'public');
        $data['cv']         = $request->file('cv')->store('uploads', 'public');
        $data['lettre']     = $request->file('lettre')->store('uploads', 'public');
        $data['certificat'] = $request->file('certificat')->store('uploads', 'public');

        DemandeStage::create($data);

        return redirect()->route('demande.form')
            ->with('success', 'Votre demande a été soumise avec succès. Elle sera traitée prochainement.');
    }

    public function index()
    {
        $demandes = DemandeStage::latest()->get();
        return view('encadrant.demandes.index', compact('demandes'));
    }

    public function show(DemandeStage $demande)
    {
        return view('encadrant.demandes.show', compact('demande'));
    }

    public function accept(Request $request, DemandeStage $demande)
    {
        $request->validate(['password' => 'required|string|min:6']);

        $password = $request->input('password');

        DB::transaction(function () use ($demande, $password) {
            $stagiaire = Stagiaire::create([
                'sexe'      => $demande->sexe,
                'nom'       => $demande->nom,
                'prenom'    => $demande->prenom,
                'telephone' => $demande->telephone,
                'email'     => $demande->email,
                'password'  => bcrypt($password),
                'photo'     => $demande->photo,
                'lieu'      => $demande->lieu,
                'filiere'   => $demande->filiere,
            ]);

            $year      = date('Y');
            $matricule = 'STG' . $year . str_pad($stagiaire->id, 4, '0', STR_PAD_LEFT);

            User::create([
                'nom'       => $demande->prenom . ' ' . $demande->nom,
                'matricule' => $matricule,
                'email'     => $demande->email,
                'password'  => bcrypt($password),
                'role'      => 'stagiaire',
            ]);

            $demande->update(['etat' => 'Validée', 'mot_de_passe' => bcrypt($password)]);
        });

        $stagiaire = Stagiaire::where('email', $demande->email)->first();
        $user      = User::where('email', $demande->email)->first();
        $waLink    = WhatsAppHelper::credentialsLink($demande->telephone, $demande->prenom, $user->matricule, $password);

        return redirect()->route('encadrant.demandes.index')
            ->with('success', 'Demande validée.')
            ->with('whatsapp_link', $waLink);
    }

    public function refuse(DemandeStage $demande)
    {
        $demande->update(['etat' => 'Refusée']);
        return redirect()->route('encadrant.demandes.index')
            ->with('success', 'Demande refusée.');
    }
}
