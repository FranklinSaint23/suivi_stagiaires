@extends('layouts.app')
@section('title', 'Ma localisation')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Stagiaire</p>
    <a href="{{ route('stagiaire.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🏠 Mon espace</a>
    <a href="{{ route('stagiaire.geolocaliser') }}" class="block px-3 py-2 rounded bg-purple-700 text-sm">📍 Ma localisation</a>
@endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Ma localisation</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-md">
    <p class="text-sm text-gray-600 mb-4">
        Cliquez sur le bouton pour enregistrer votre position GPS actuelle.
    </p>
    @if($stagiaire->latitude)
        <p class="text-sm text-green-600 mb-4">
            Position actuelle : {{ $stagiaire->latitude }}, {{ $stagiaire->longitude }}
        </p>
    @endif
    <button id="geoBtn"
            class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">
        📍 Localiser ma position
    </button>
    <p id="status" class="mt-3 text-sm text-gray-500"></p>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('geoBtn').addEventListener('click', function() {
    const status = document.getElementById('status');
    if (!navigator.geolocation) {
        status.textContent = 'Géolocalisation non supportée par votre navigateur.';
        return;
    }
    status.textContent = 'Localisation en cours...';
    navigator.geolocation.getCurrentPosition(function(pos) {
        fetch('{{ route("stagiaire.position.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                stagiaire_id: {{ $stagiaire->id }},
                latitude: pos.coords.latitude,
                longitude: pos.coords.longitude
            })
        })
        .then(r => r.json())
        .then(data => {
            status.textContent = data.success ?? data.error;
            status.className = data.success ? 'mt-3 text-sm text-green-600' : 'mt-3 text-sm text-red-500';
        });
    }, function() {
        status.textContent = 'Impossible d\'obtenir la position.';
    });
});
</script>
@endpush
