@extends('layouts.app')
@section('title', 'Choisir stagiaire — Attestation')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Générer une attestation</h1>
<div class="bg-white rounded-xl shadow p-6 max-w-md">
    <form method="GET" id="form">
        <label class="block text-sm font-medium text-gray-700 mb-2">Choisir le stagiaire</label>
        <select name="id" required class="w-full border rounded px-3 py-2 text-sm mb-4">
            <option value="">-- Choisir --</option>
            @foreach($stagiaires as $s)
                <option value="{{ $s->id }}">{{ $s->nom }} {{ $s->prenom }}</option>
            @endforeach
        </select>
        <button type="button" onclick="go()"
                class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">
            📜 Télécharger l'attestation
        </button>
    </form>
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
