@extends('layouts.app')
@section('title', 'Pointer Présence')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-calendar-check text-emerald-400"></i>
            <span>Pointer une <span class="gradient-text">Présence</span></span>
        </h1>
        <p class="text-sm text-slate-400 mt-1">Enregistrez la présence journalière d'un stagiaire</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-lg border border-slate-800 shadow-xl">
        <form action="{{ route('encadrant.presences.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Stagiaire *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <select name="stagiaire_id" required class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                        <option value="" class="bg-slate-900 text-slate-400">-- Choisir un stagiaire --</option>
                        @foreach($stagiaires as $s)
                            <option value="{{ $s->id }}" class="bg-slate-900 text-slate-100">{{ $s->nom }} {{ $s->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Date *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-calendar text-sm"></i>
                    </div>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Statut de Présence *</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center justify-center gap-2 p-3 bg-slate-900 border border-emerald-500/30 rounded-xl cursor-pointer hover:bg-emerald-500/10 transition">
                        <input type="radio" name="present" value="1" required class="accent-emerald-500 w-4 h-4">
                        <span class="text-sm text-emerald-400 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i> Présent
                        </span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-3 bg-slate-900 border border-rose-500/30 rounded-xl cursor-pointer hover:bg-rose-500/10 transition">
                        <input type="radio" name="present" value="0" class="accent-rose-500 w-4 h-4">
                        <span class="text-sm text-rose-400 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-xmark"></i> Absent
                        </span>
                    </label>
                </div>
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="flex-1 gradient-bg-primary hover:opacity-95 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Enregistrer</span>
                </button>
                <a href="{{ route('encadrant.presences.index') }}" 
                   class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-3 rounded-xl text-sm font-medium transition">
                    Voir récap
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

