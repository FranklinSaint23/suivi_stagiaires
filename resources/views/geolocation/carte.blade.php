@extends('layouts.app')
@section('title', 'Carte interactive')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-purple-900">Carte des stagiaires</h1>
    <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Rechercher..."
               class="border rounded px-3 py-2 text-sm">
        <button class="bg-purple-700 text-white px-3 py-2 rounded text-sm">Filtrer</button>
    </form>
</div>

<div id="map" class="rounded-xl shadow" style="height: 500px;"></div>

<div class="mt-4 text-sm text-gray-500">
    {{ $stagiaires->count() }} stagiaire(s) géolocalisé(s).
    Cliquez sur la carte pour ajouter une position.
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([7.3697, 12.3547], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

const stagiaires = @json($stagiaires);

stagiaires.forEach(s => {
    L.marker([s.latitude, s.longitude])
     .addTo(map)
     .bindPopup(`<b>${s.prenom} ${s.nom}</b><br>${s.filiere ?? ''} — ${s.lieu ?? ''}`);
});

map.on('click', function(e) {
    const nom = prompt('Nom du stagiaire :');
    if (!nom) return;
    const prenom = prompt('Prénom :');
    if (!prenom) return;

    fetch('{{ route("encadrant.carte_interactive") }}'.replace('carte-interactive', 'position') + '?_method=POST', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            nom: nom,
            prenom: prenom,
            latitude: e.latlng.lat,
            longitude: e.latlng.lng
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            L.marker([e.latlng.lat, e.latlng.lng])
             .addTo(map)
             .bindPopup(`<b>${prenom} ${nom}</b>`)
             .openPopup();
        } else {
            alert('Stagiaire non trouvé en base.');
        }
    });
});
</script>
@endpush
