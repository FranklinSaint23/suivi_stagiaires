@extends('layouts.app')
@section('title', 'Messages des Stagiaires')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-comments text-purple-400"></i>
                <span>Messages des <span class="gradient-text">Stagiaires</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Répondez aux questions et messages envoyés par les stagiaires</p>
        </div>
    </div>

    @forelse($messages as $msg)
    <div class="glass-panel rounded-2xl p-5 sm:p-6 border border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 text-indigo-400 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($msg->stagiaire?->nom ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-100 text-base">{{ $msg->stagiaire?->prenom }} {{ $msg->stagiaire?->nom }}</h3>
                    <p class="text-xs text-slate-400"><i class="fa-regular fa-clock mr-1"></i>{{ $msg->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @if(!$msg->lu)
                <span class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-xs px-2.5 py-1 rounded-full font-semibold">
                    <i class="fa-solid fa-envelope text-[10px]"></i> Non lu
                </span>
            @endif
        </div>

        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-4 text-slate-200 text-sm leading-relaxed">
            {{ $msg->message }}
        </div>

        @foreach($msg->reponses as $rep)
            <div class="ml-4 sm:ml-8 bg-slate-950/90 border border-indigo-500/30 rounded-xl p-4 text-sm space-y-1">
                <div class="flex items-center justify-between text-emerald-400 font-semibold text-xs">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-shield"></i> Votre réponse</span>
                    <span class="text-slate-500 font-normal">{{ $rep->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <p class="text-slate-300 text-xs leading-relaxed">{{ $rep->reponse }}</p>
            </div>
        @endforeach

        <form action="{{ route('encadrant.messages.reply', $msg) }}" method="POST" class="pt-2 space-y-3">
            @csrf
            <textarea name="reponse" rows="2" required placeholder="Rédiger votre réponse..."
                      class="w-full bg-slate-900 border border-slate-700/80 rounded-xl p-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition"></textarea>
            <div class="flex items-center justify-between gap-3">
                <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold px-4 py-2 rounded-xl text-sm shadow-md transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Répondre
                </button>
                @if($msg->stagiaire?->telephone)
                    @php
                        $phone = preg_replace('/\s+/', '', $msg->stagiaire->telephone);
                        if (str_starts_with($phone, '0')) $phone = '237' . substr($phone, 1);
                        elseif (!str_starts_with($phone, '237')) $phone = '237' . $phone;
                    @endphp
                    <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Bonjour ' . $msg->stagiaire->prenom . ', vous avez reçu une réponse à votre message.') }}"
                       target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-2 rounded-xl transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i> Contacter via WhatsApp
                    </a>
                @endif
            </div>
        </form>
    </div>
    @empty
        <div class="glass-panel rounded-2xl p-12 border border-slate-800 text-center text-slate-400">
            <i class="fa-solid fa-comments text-4xl mb-3 opacity-30 block"></i>
            <p class="text-sm font-medium">Aucun message reçu pour le moment.</p>
        </div>
    @endforelse
</div>
@endsection

