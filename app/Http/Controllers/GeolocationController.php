<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->input('q');
        $stagiaires = Stagiaire::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($search, function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            })
            ->get();

        $tous = Stagiaire::orderBy('nom')->get();

        return view('geolocation.carte', compact('stagiaires', 'tous', 'search'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'stagiaire_id' => 'sometimes|exists:stagiaires,id',
            'nom'          => 'sometimes|string',
            'prenom'       => 'sometimes|string',
            'latitude'     => 'required|numeric|between:-90,90',
            'longitude'    => 'required|numeric|between:-180,180',
        ]);

        if (!empty($data['stagiaire_id'])) {
            $stagiaire = Stagiaire::find($data['stagiaire_id']);
        } else {
            $stagiaire = Stagiaire::where('nom', $data['nom'] ?? '')
                ->where('prenom', $data['prenom'] ?? '')
                ->first();
        }

        if (!$stagiaire) {
            return response()->json(['error' => 'Stagiaire introuvable.'], 404);
        }

        $stagiaire->update([
            'latitude'  => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        return response()->json(['success' => 'Position enregistrée.']);
    }

    public function myLocation(Request $request)
    {
        $stagiaire = Stagiaire::where('email', auth()->user()->email)->first();
        if (!$stagiaire) {
            return back()->withErrors(['error' => 'Profil stagiaire introuvable.']);
        }
        return view('stagiaire.geolocaliser', compact('stagiaire'));
    }
}
