@extends('layouts.app')
@section('title', 'Mon Espace Stagiaire')

@section('sidebar')
<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Espace Stagiaire</p>
</div>
<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('stagiaire.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-house w-5 text-center text-base {{ request()->routeIs('stagiaire.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Mon Espace</span>
    </a>
    <a href="{{ route('stagiaire.pdf.presences') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.pdf.presences') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-file-pdf w-5 text-center text-base {{ request()->routeIs('stagiaire.pdf.presences') ? 'text-white' : 'text-rose-400' }}"></i>
        <span>Mes présences PDF</span>
    </a>
    <a href="{{ route('stagiaire.geolocaliser') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.geolocaliser') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-location-dot w-5 text-center text-base {{ request()->routeIs('stagiaire.geolocaliser') ? 'text-white' : 'text-emerald-400' }}"></i>
        <span>Ma Localisation</span>
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-hand-wave text-amber-400"></i>
                <span>Bonjour, <span class="gradient-text">{{ $stagiaire?->prenom ?? auth()->user()->nom }}</span> 👋</span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Bienvenue sur votre espace de suivi de stage académique</p>
        </div>
        
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold px-3.5 py-2 rounded-xl">
                <i class="fa-solid fa-user-graduate"></i> Stagiaire Actif
            </span>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Mes Présences Card -->
        <div class="glass-panel rounded-2xl p-5 border border-slate-800 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <h2 class="font-bold text-slate-100 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-emerald-400"></i> Mes présences
                    </h2>
                    <form method="GET" class="flex items-center gap-2 text-xs">
                        <select name="mois" class="bg-slate-900 border border-slate-700/80 rounded-xl px-2.5 py-1.5 text-slate-100 focus:outline-none focus:border-indigo-500">
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ $m == $mois ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('fr')->isoFormat('MMMM')) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="annee" value="{{ $annee }}" class="bg-slate-900 border border-slate-700/80 rounded-xl px-2 py-1.5 text-slate-100 w-20 focus:outline-none focus:border-indigo-500">
                        <button class="gradient-bg-primary hover:opacity-95 text-white px-3 py-1.5 rounded-xl font-medium transition">Filtrer</button>
                    </form>
                </div>

                @if($presences->isEmpty())
                    <div class="text-center py-10 text-slate-400">
                        <i class="fa-solid fa-calendar-xmark text-4xl mb-3 opacity-40"></i>
                        <p class="text-sm">Aucune présence enregistrée pour ce mois.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-slate-800">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                @foreach($presences as $p)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="px-4 py-3 font-medium text-slate-200">
                                        <i class="fa-regular fa-calendar text-slate-400 mr-2"></i>
                                        {{ $p->date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if($p->present)
                                            <span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full text-xs font-semibold">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Présent
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2.5 py-1 rounded-full text-xs font-semibold">
                                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Absent
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-t border-slate-800 text-right">
                <a href="{{ route('stagiaire.pdf.presences') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 inline-flex items-center gap-1 transition">
                    <i class="fa-solid fa-download"></i> Télécharger mon récapitulatif PDF
                </a>
            </div>
        </div>

        <!-- Messaging Card -->
        <div class="glass-panel rounded-2xl p-5 border border-slate-800 shadow-xl flex flex-col justify-between">
            <div>
                <h2 class="font-bold text-slate-100 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-comments text-purple-400"></i> Messagerie avec l'encadrant
                </h2>

                <form action="{{ route('stagiaire.messages.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="message" rows="3" required
                              class="w-full bg-slate-900 border border-slate-700/80 rounded-xl p-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition"
                              placeholder="Rédigez votre message à l'attention de l'encadrant..."></textarea>
                    <button type="submit"
                            class="gradient-bg-primary hover:opacity-95 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition text-sm inline-flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Envoyer le message
                    </button>
                </form>

                @if($messages->isNotEmpty())
                    <h3 class="font-semibold text-xs uppercase tracking-wider text-slate-400 mt-6 mb-3">Historique des échanges</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @foreach($messages as $msg)
                        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-3 text-sm space-y-2">
                            <div class="flex justify-between items-start text-indigo-300 font-medium">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-circle"></i> Vous</span>
                                <span class="text-[10px] text-slate-500 font-normal">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-slate-200 text-xs leading-relaxed">{{ $msg->message }}</p>

                            @foreach($msg->reponses as $rep)
                                <div class="mt-2 ml-3 bg-slate-950/80 border border-indigo-500/30 rounded-xl p-2.5 space-y-1">
                                    <div class="flex justify-between items-center text-emerald-400 font-semibold text-xs">
                                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-shield"></i> Encadrant</span>
                                        <span class="text-[10px] text-slate-500 font-normal">{{ $rep->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-slate-300 text-xs">{{ $rep->reponse }}</p>
                                </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Floating AI Chatbot Button -->
<div id="chatbot-bubble"
     onclick="document.getElementById('chatbot-panel').classList.toggle('hidden'); this.classList.add('hidden')"
     class="fixed bottom-6 right-6 gradient-bg-primary hover:scale-110 text-white w-14 h-14 rounded-2xl shadow-2xl shadow-indigo-600/50 flex items-center justify-center text-2xl cursor-pointer z-50 transition transform duration-200"
     title="Assistant IA Stagiaire">
    <i class="fa-solid fa-robot"></i>
</div>

<!-- Floating AI Chat Panel -->
<div id="chatbot-panel" class="hidden fixed bottom-6 right-6 w-80 sm:w-96 glass-panel rounded-2xl shadow-2xl border border-indigo-500/30 flex flex-col z-50 overflow-hidden" style="height:480px">
    <div class="gradient-bg-primary text-white px-4 py-3 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white font-bold">
                <i class="fa-solid fa-robot text-sm"></i>
            </div>
            <div>
                <span class="font-bold text-sm block">Assistant Virtuel IA</span>
                <span class="text-[10px] text-indigo-200 block">Toujours prêt à vous aider</span>
            </div>
        </div>
        <button onclick="document.getElementById('chatbot-panel').classList.add('hidden'); document.getElementById('chatbot-bubble').classList.remove('hidden')"
                class="text-white/80 hover:text-white text-xl leading-none p-1">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 text-xs bg-slate-950/70">
        <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-200 rounded-2xl p-3 leading-relaxed">
            👋 Bonjour ! Je suis votre assistant académique. Posez-moi vos questions concernant le stage, les présences ou les attestations.
        </div>
    </div>

    <div class="border-t border-slate-800 p-3 bg-slate-900/90 flex gap-2">
        <input id="chat-input" type="text" placeholder="Écrivez votre message..."
               class="flex-1 bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500"
               onkeydown="if(event.key==='Enter') envoyerMessage()">
        <button onclick="envoyerMessage()"
                class="gradient-bg-primary hover:opacity-95 text-white px-3 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chatHistorique = [];

async function envoyerMessage() {
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;

    input.value = '';
    ajouterMessage('user', msg);

    const typingId = ajouterTyping();

    try {
        const res = await fetch('{{ route('stagiaire.ai.chat') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg, historique: chatHistorique })
        });

        const data = await res.json();
        supprimerTyping(typingId);

        if (data.reponse) {
            chatHistorique.push({ role: 'user', content: msg });
            chatHistorique.push({ role: 'assistant', content: data.reponse });
            if (chatHistorique.length > 20) chatHistorique.splice(0, 2);
            ajouterMessage('assistant', data.reponse);
        } else {
            ajouterMessage('error', data.error ?? 'Erreur inconnue.');
        }
    } catch (e) {
        supprimerTyping(typingId);
        ajouterMessage('error', 'Impossible de joindre le serveur.');
    }
}

function ajouterMessage(type, texte) {
    const box = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = type === 'user'
        ? 'bg-indigo-600 text-white rounded-2xl p-3 ml-6 shadow-md'
        : type === 'error'
        ? 'bg-rose-500/10 border border-rose-500/20 text-rose-300 rounded-2xl p-3 text-xs'
        : 'bg-slate-900 border border-slate-800 text-slate-200 rounded-2xl p-3 mr-6';
    div.textContent = texte;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
    return div;
}

function ajouterTyping() {
    const box = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.id = 'typing-' + Date.now();
    div.className = 'bg-slate-900 border border-slate-800 text-indigo-400 rounded-2xl p-3 mr-6 italic text-xs flex items-center gap-2';
    div.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Assistant écrit...';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
    return div.id;
}

function supprimerTyping(id) {
    document.getElementById(id)?.remove();
}
</script>
@endpush

