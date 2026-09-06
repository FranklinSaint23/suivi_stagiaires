@extends('layouts.app')
@section('title', 'Récapitulatif des présences')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-calendar-days text-indigo-400"></i>
                <span>Récapitulatif des <span class="gradient-text">Présences</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Matrice mensuelle du suivi de présence des stagiaires</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <button onclick="detecterAnomalies()" id="btn-anomalies"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span id="btn-anomalies-text">Détecter anomalies IA</span>
            </button>

            <a href="{{ route('encadrant.pdf.presences', ['mois' => $mois, 'annee' => $annee]) }}"
               class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-500 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-rose-600/20 transition">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Exporter PDF</span>
            </a>
        </div>
    </div>

    <!-- IA Anomalies Result Box -->
    <div id="ai-anomalies-box" class="hidden glass-panel border border-amber-500/30 rounded-2xl p-5 shadow-2xl relative overflow-hidden">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-brain"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-100 text-base mb-2">Rapport d'analyse d'anomalies par IA</h3>
                <div id="ai-anomalies-text" class="text-sm text-slate-300 whitespace-pre-line leading-relaxed"></div>
            </div>
        </div>
    </div>
    <div id="ai-anomalies-error" class="hidden p-4 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-xl text-sm"></div>

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
            err.textContent = '⚠️ Erreur de connexion au service d\'IA.';
            err.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            txt.textContent = 'Détecter anomalies IA';
        }
    }
    </script>
    @endpush

    <!-- Filter Form -->
    <div class="glass-panel p-4 rounded-2xl border border-slate-800">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-slate-400 uppercase">Mois :</label>
                <select name="mois" class="bg-slate-900 border border-slate-700/80 rounded-xl px-3 py-2 text-sm text-slate-100 focus:outline-none focus:border-indigo-500">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $m == $mois ? 'selected' : '' }}>
                            {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('fr')->isoFormat('MMMM')) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-slate-400 uppercase">Année :</label>
                <input type="number" name="annee" value="{{ $annee }}" class="bg-slate-900 border border-slate-700/80 rounded-xl px-3 py-2 text-sm text-slate-100 w-24 focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">
                <i class="fa-solid fa-filter mr-1"></i> Filtrer
            </button>
        </form>
    </div>

    <!-- Attendance Grid Table -->
    <div class="glass-panel rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="text-xs border-collapse w-full">
                <thead class="bg-slate-900/90 text-slate-300 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3.5 text-left sticky left-0 bg-slate-900 z-10 border-r border-slate-800 font-semibold">Stagiaire</th>
                        @for($j = 1; $j <= $nbJours; $j++)
                            <th class="px-2 py-3.5 text-center font-semibold min-w-[28px]">{{ $j }}</th>
                        @endfor
                        <th class="px-3 py-3.5 text-center font-semibold bg-slate-900 border-l border-slate-800 text-indigo-400">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300">
                    @foreach($stagiaires as $s)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-semibold text-white whitespace-nowrap sticky left-0 bg-slate-950 border-r border-slate-800 shadow-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-800 text-indigo-400 text-[10px] font-bold flex items-center justify-center border border-slate-700">
                                    {{ strtoupper(substr($s->nom, 0, 1)) }}
                                </div>
                                <span>{{ $s->nom }} {{ $s->prenom }}</span>
                            </div>
                        </td>
                        @php $totalP = 0; @endphp
                        @for($j = 1; $j <= $nbJours; $j++)
                            @php
                                $day = sprintf('%04d-%02d-%02d', $annee, $mois, $j);
                                $p = $presencesMap[$s->id][$day] ?? null;
                            @endphp
                            <td class="text-center py-2 min-w-[28px]">
                                @if($p)
                                    @if($p->present)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">P</span>
                                        @php $totalP++; @endphp
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-rose-500/20 text-rose-400 font-bold border border-rose-500/30">A</span>
                                    @endif
                                @else
                                    <span class="text-slate-600 font-medium">-</span>
                                @endif
                            </td>
                        @endfor
                        <td class="text-center font-extrabold text-indigo-400 bg-slate-900/60 border-l border-slate-800 py-2">
                            {{ $totalP }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

