@extends('layouts.app')
@section('title', 'Centre de Notifications')

@section('sidebar')
    @if(auth()->user()->role === 'admin')
        @include('admin.partials.sidebar')
    @elseif(auth()->user()->role === 'encadrant')
        @include('encadrant.partials.sidebar')
    @elseif(auth()->user()->role === 'stagiaire')
        @include('stagiaire.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 dark:border-slate-800 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-bell text-indigo-600 dark:text-indigo-400"></i> Centre de Notifications
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Vos alertes, rappels et mises à jour système</p>
        </div>
        <form action="{{ route('notifications.read_all') }}" method="POST">
            @csrf
            <button type="submit" class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-check-double"></i> Tout marquer comme lu
            </button>
        </form>
    </div>

    <div class="space-y-3">
        @forelse($notifications as $n)
            <div class="glass-panel p-5 rounded-2xl border flex items-start justify-between gap-4 transition bg-white dark:bg-slate-900/70 {{ $n->lu ? 'border-slate-200 dark:border-slate-800/80 opacity-75' : 'border-indigo-500/40 bg-indigo-50/50 dark:bg-indigo-500/5 shadow-md' }}">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-base font-bold {{ $n->type === 'success' ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : ($n->type === 'danger' ? 'bg-rose-500/20 text-rose-600 dark:text-rose-400' : ($n->type === 'warning' ? 'bg-amber-500/20 text-amber-600 dark:text-amber-300' : 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-300')) }}">
                        <i class="fa-solid {{ $n->type === 'success' ? 'fa-check' : ($n->type === 'danger' ? 'fa-triangle-exclamation' : ($n->type === 'warning' ? 'fa-bell' : 'fa-info')) }}"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base leading-snug">{{ $n->titre }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $n->message }}</p>
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-mono block pt-1">{{ $n->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @if($n->lien)
                    <a href="{{ route('notifications.read', $n) }}" class="gradient-bg-primary text-white text-xs font-semibold px-3.5 py-2 rounded-xl shrink-0 transition hover:opacity-90 shadow-sm">
                        Voir
                    </a>
                @endif
            </div>
        @empty
            <div class="glass-panel p-8 rounded-2xl text-center text-slate-500 dark:text-slate-400 py-12 bg-white dark:bg-slate-900/70 border border-slate-200 dark:border-slate-800">
                <i class="fa-solid fa-bell-slash text-4xl text-slate-400 dark:text-slate-600 mb-3 block"></i>
                <p>Aucune notification enregistrée.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
