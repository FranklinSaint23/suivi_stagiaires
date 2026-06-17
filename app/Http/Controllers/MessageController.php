<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsAppHelper;
use App\Models\Message;
use App\Models\Reponse;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('stagiaire', 'reponses')
            ->where('expediteur', 'stagiaire')
            ->latest()
            ->get();

        return view('encadrant.messages.index', compact('messages'));
    }

    public function storeFromStagiaire(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $user      = auth()->user();
        $stagiaire = Stagiaire::where('email', $user->email)->first();

        if (!$stagiaire) {
            return back()->withErrors(['message' => 'Profil stagiaire introuvable.']);
        }

        Message::create([
            'stagiaire_id' => $stagiaire->id,
            'message'      => $request->input('message'),
            'expediteur'   => 'stagiaire',
        ]);

        return redirect()->route('stagiaire.dashboard')
            ->with('success', 'Message envoyé.');
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate(['reponse' => 'required|string|max:2000']);

        Reponse::create([
            'message_id' => $message->id,
            'reponse'    => $request->input('reponse'),
        ]);

        $message->update(['lu' => true]);

        $phone  = $message->stagiaire->telephone ?? '';
        $waLink = $phone
            ? WhatsAppHelper::messageLink($phone, "Vous avez reçu une réponse à votre message.")
            : null;

        return redirect()->route('encadrant.messages.index')
            ->with('success', 'Réponse envoyée.')
            ->with('whatsapp_link', $waLink);
    }
}
