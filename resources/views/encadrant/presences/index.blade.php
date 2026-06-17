@extends('layouts.app')
@section('title', 'Récap présences')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-purple-900">Récap des présences</h1>
    <div class="flex gap-2">
        <button onclick="detecterAnomalies()" id="btn-anomalies"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold">
            🤖 <span id="btn-anomalies-text">Détecter anomalies IA</span>
        </button>
        <a href="{{ route('encadrant.pdf.presences', ['mois' => $mois, 'annee' => $annee]) }}"
           class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800 text-sm">📊 Exporter PDF</a>
    </div>
</div>

{{-- Résultat détection anomalies --}}
<div id="ai-anomalies-box" class="hidden mb-6 bg-amber-50 border border-amber-300 rounded-xl p-5">
    <h3 class="font-bold text-amber-800 mb-3">🤖 Analyse IA des présences</h3>
    <div id="ai-anomalies-text" class="text-sm text-gray-700 whitespace-pre-line leading-relaxed"></div>
</div>
<div id="ai-anomalies-error" class="hidden mb-4 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4 text-sm"></div>

@push('scripts')
<script>
async function detecterAnomalies() {
    const btn = document.getElementById('btn-anomalies');
    const txt = document.getElementById('btn-anomalies-text');
    const box = document.getElementById('ai-anomalies-box');
    const err = document.getElementById('ai-anomalies-error');

    btn.disabled = true;
    txt.textContent = 'Analyse en cours…';
    box.classList.add('hidden');
    err.classList.add('hidden');

    try {
        const r = await fetch('{{ route('encadrant.ai.anomalies') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await r.json();
        if (data.result) {
            document.getElementById('ai-anomalies-text').textContent = data.result;
            box.classList.remove('hidden');
        } else {
            err.textContent = '⚠️ ' + (data.error ?? 'Erreur inconnue');
            err.classList.remove('hidden');
        }
    } catch(e) {
        err.textContent = '⚠️ Erreur de connexion.';
        err.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        txt.textContent = 'Détecter anomalies IA';
    }
}
</script>
@endpush


<div class="bg-white rounded-xl shadow p-4 mb-4">
    <form method="GET" class="flex gap-3">
        <select name="mois" class="border rounded px-3 py-2 text-sm">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $m == $mois ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->locale('fr')->isoFormat('MMMM') }}
                </option>
            @endforeach
        </select>
        <input type="number" name="annee" value="{{ $annee }}" class="border rounded px-3 py-2 text-sm w-24">
        <button class="bg-purple-700 text-white px-4 py-2 rounded text-sm">Afficher</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="text-xs border-collapse w-full">
        <thead class="bg-purple-800 text-white">
            <tr>
                <th class="px-3 py-2 text-left sticky left-0 bg-purple-800">Stagiaire</th>
                @for($j = 1; $j <= $nbJours; $j++)
                    <th class="px-2 py-2 text-center">{{ $j }}</th>
                @endfor
                <th class="px-2 py-2 text-center">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($stagiaires as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-3 py-2 font-medium whitespace-nowrap sticky left-0 bg-white border-r">
                    {{ $s->nom }} {{ $s->prenom }}
                </td>
                @php $totalP = 0; @endphp
                @for($j = 1; $j <= $nbJours; $j++)
                    @php
                        $day = sprintf('%04d-%02d-%02d', $annee, $mois, $j);
                        $p = $presencesMap[$s->id][$day] ?? null;
                    @endphp
                    <td class="text-center py-2">
                        @if($p)
                            @if($p->present)
                                <span class="text-green-600 font-bold">P</span>
                                @php $totalP++; @endphp
                            @else
                                <span class="text-red-500">A</span>
                            @endif
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>
                @endfor
                <td class="text-center font-bold text-purple-800">{{ $totalP }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
