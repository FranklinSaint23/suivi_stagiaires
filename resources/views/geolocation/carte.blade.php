@extends('layouts.app')
@section('title', 'Carte interactive')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-container {
        border-radius: 1rem;
        z-index: 1;
    }
    .leaflet-popup-content-wrapper {
        background: #1e293b;
        color: #f8fafc;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .leaflet-popup-tip {
        background: #1e293b;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-map-location-dot text-indigo-400"></i> Carte des Stagiaires
            </h1>
            <p class="text-slate-400 text-sm mt-1">Visualisez et géolocalisez les stagiaires en temps réel</p>
        </div>
        <form method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" name="q" value="{{ $search }}" placeholder="Rechercher par nom..."
                   class="bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 transition w-full sm:w-64">
            <button class="gradient-bg-primary text-white px-4 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-filter"></i> Filtrer
            </button>
        </form>
    </div>

    <div class="glass-panel p-3 rounded-2xl relative shadow-2xl">
        <div id="map" class="w-full rounded-xl" style="height: 520px;"></div>
    </div>

    <div class="glass-card p-4 rounded-xl text-sm text-slate-300 flex items-center justify-between border border-slate-800">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-indigo-400 text-base"></i>
            <span><strong>{{ $stagiaires->count() }}</strong> stagiaire(s) actuellement géolocalisé(s).</span>
        </div>
        <span class="text-xs text-slate-400 hidden sm:inline">Astuce : Cliquez n'importe où sur la carte pour affecter manuellement une position.</span>
    </div>
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
     .bindPopup(`<div class="p-1"><b class="text-indigo-400 text-sm">${s.prenom} ${s.nom}</b><br><span class="text-xs text-slate-300">${s.filiere ?? ''} — ${s.lieu ?? ''}</span></div>`);
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
             .bindPopup(`<div class="p-1"><b class="text-indigo-400 text-sm">${prenom} ${nom}</b></div>`)
             .openPopup();
        } else {
            alert('Stagiaire non trouvé en base.');
        }
    });
});
</script>
@endpush
