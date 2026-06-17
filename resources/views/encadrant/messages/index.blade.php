@extends('layouts.app')
@section('title', 'Messages')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">Messages des stagiaires</h1>

@forelse($messages as $msg)
<div class="bg-white rounded-xl shadow p-5 mb-4">
    <div class="flex justify-between items-start mb-3">
        <div>
            <p class="font-semibold text-purple-800">{{ $msg->stagiaire?->prenom }} {{ $msg->stagiaire?->nom }}</p>
            <p class="text-xs text-gray-400">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
        </div>
        @if(!$msg->lu)
            <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded">Non lu</span>
        @endif
    </div>
    <p class="text-gray-700 text-sm mb-4 bg-purple-50 rounded p-3">{{ $msg->message }}</p>

    @foreach($msg->reponses as $rep)
        <div class="ml-6 bg-green-50 border border-green-200 rounded p-3 mb-2 text-sm">
            <p class="text-gray-700">{{ $rep->reponse }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $rep->created_at->format('d/m/Y H:i') }}</p>
        </div>
    @endforeach

    <form action="{{ route('encadrant.messages.reply', $msg) }}" method="POST" class="mt-3">
        @csrf
        <textarea name="reponse" rows="3" required placeholder="Votre réponse..."
                  class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500"></textarea>
        <div class="flex justify-between mt-2">
            <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded text-sm hover:bg-purple-800">
                Répondre
            </button>
            @if($msg->stagiaire?->telephone)
                @php
                    $phone = preg_replace('/\s+/', '', $msg->stagiaire->telephone);
                    if (str_starts_with($phone, '0')) $phone = '237' . substr($phone, 1);
                    elseif (!str_starts_with($phone, '237')) $phone = '237' . $phone;
                @endphp
                <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Bonjour ' . $msg->stagiaire->prenom . ', vous avez reçu une réponse à votre message.') }}"
                   target="_blank" class="text-green-600 text-sm hover:underline">📱 WhatsApp</a>
            @endif
        </div>
    </form>
</div>
@empty
    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">Aucun message.</div>
@endforelse
@endsection
