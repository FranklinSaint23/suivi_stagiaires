@extends('layouts.app')
@section('title', 'Générer Attestation')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-file-pdf text-rose-400"></i>
            <span>Générer une <span class="gradient-text">Attestation de Stage</span></span>
        </h1>
        <p class="text-sm text-slate-400 mt-1">Générez et téléchargez l'attestation de fin de stage au format PDF</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-lg border border-slate-800 shadow-xl space-y-5">
        <form method="GET" id="form" class="space-y-5">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    Sélectionner le stagiaire
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <select name="id" required class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                        <option value="" class="bg-slate-900 text-slate-400">-- Choisir un stagiaire --</option>
                        @foreach($stagiaires as $s)
                            <option value="{{ $s->id }}" class="bg-slate-900 text-slate-100">{{ $s->nom }} {{ $s->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="button" onclick="go()"
                    class="w-full bg-rose-600 hover:bg-rose-500 text-white font-semibold py-3 px-5 rounded-xl shadow-lg shadow-rose-600/30 transition text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>Télécharger l'Attestation PDF</span>
            </button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
function go() {
    const id = document.querySelector('[name=id]').value;
    if (id) window.location = '/encadrant/pdf/attestation/' + id;
}
</script>
@endpush

