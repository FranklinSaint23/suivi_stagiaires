@extends('layouts.app')
@section('title', 'Mon Espace')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Stagiaire</p>
    <a href="{{ route('stagiaire.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🏠 Mon espace</a>
    <a href="{{ route('stagiaire.pdf.presences') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📊 Mes présences PDF</a>
    <a href="{{ route('stagiaire.geolocaliser') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📍 Ma localisation</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">
    Bonjour {{ $stagiaire?->prenom ?? auth()->user()->nom }} 👋
</h1>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Présences du mois -->
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">Mes présences</h2>
            <form method="GET" class="flex gap-2 text-sm">
                <select name="mois" class="border rounded px-2 py-1">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $m == $mois ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->locale('fr')->isoFormat('MMMM') }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="annee" value="{{ $annee }}" class="border rounded px-2 py-1 w-20">
                <button class="bg-purple-700 text-white px-3 py-1 rounded hover:bg-purple-800">OK</button>
            </form>
        </div>

        @if($presences->isEmpty())
            <p class="text-gray-500 text-sm">Aucune présence enregistrée ce mois.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-purple-50 text-purple-900">
                        <tr>
                            <th class="px-3 py-2 text-left">Date</th>
                            <th class="px-3 py-2 text-left">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($presences as $p)
                        <tr>
                            <td class="px-3 py-2">{{ $p->date->format('d/m/Y') }}</td>
                            <td class="px-3 py-2">
                                @if($p->present)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Présent</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Absent</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Messages -->
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Envoyer un message à l'encadrant</h2>
        <form action="{{ route('stagiaire.messages.store') }}" method="POST">
            @csrf
            <textarea name="message" rows="4" required
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500"
                      placeholder="Votre message..."></textarea>
            <button type="submit"
                    class="mt-2 bg-purple-800 text-white px-4 py-2 rounded hover:bg-purple-700 text-sm">
                Envoyer
            </button>
        </form>

        @if($messages->isNotEmpty())
            <h3 class="font-medium text-gray-600 mt-6 mb-3">Mes messages et réponses</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach($messages as $msg)
                <div class="bg-purple-50 rounded-lg p-3 text-sm">
                    <p class="text-purple-900 font-medium">Vous : {{ $msg->message }}</p>
                    <p class="text-xs text-gray-400">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
                    @foreach($msg->reponses as $rep)
                        <div class="mt-2 ml-4 bg-white border border-purple-200 rounded p-2">
                            <p class="text-gray-700">Encadrant : {{ $rep->reponse }}</p>
                            <p class="text-xs text-gray-400">{{ $rep->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Chatbot IA flottant --}}
<div id="chatbot-bubble"
     onclick="document.getElementById('chatbot-panel').classList.toggle('hidden'); this.classList.add('hidden')"
     class="fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white w-14 h-14 rounded-full shadow-xl flex items-center justify-center text-2xl cursor-pointer z-50"
     title="Assistant IA">
    🤖
</div>

<div id="chatbot-panel" class="hidden fixed bottom-6 right-6 w-80 bg-white rounded-2xl shadow-2xl border border-indigo-200 flex flex-col z-50" style="height:420px">
    <div class="bg-indigo-600 text-white px-4 py-3 rounded-t-2xl flex justify-between items-center">
        <span class="font-semibold text-sm">🤖 Assistant IA</span>
        <button onclick="document.getElementById('chatbot-panel').classList.add('hidden'); document.getElementById('chatbot-bubble').classList.remove('hidden')"
                class="text-indigo-200 hover:text-white text-lg leading-none">×</button>
    </div>

    <div id="chat-messages" class="flex-1 overflow-y-auto p-3 space-y-2 text-sm">
        <div class="bg-indigo-50 text-indigo-800 rounded-lg px-3 py-2">
            Bonjour ! Je suis votre assistant. Posez-moi une question sur votre stage, vos absences ou les procédures.
        </div>
    </div>

    <div class="border-t p-3 flex gap-2">
        <input id="chat-input" type="text" placeholder="Votre question..."
               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
               onkeydown="if(event.key==='Enter') envoyerMessage()">
        <button onclick="envoyerMessage()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-bold">→</button>
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
        ? 'bg-purple-100 text-purple-900 rounded-lg px-3 py-2 ml-4'
        : type === 'error'
        ? 'bg-red-50 text-red-700 rounded-lg px-3 py-2 text-xs'
        : 'bg-indigo-50 text-indigo-800 rounded-lg px-3 py-2 mr-4';
    div.textContent = texte;
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
    return div;
}

function ajouterTyping() {
    const box = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.id = 'typing-' + Date.now();
    div.className = 'bg-indigo-50 text-indigo-400 rounded-lg px-3 py-2 mr-4 italic text-xs';
    div.textContent = 'En cours de réponse...';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
    return div.id;
}

function supprimerTyping(id) {
    document.getElementById(id)?.remove();
}
</script>
@endpush
