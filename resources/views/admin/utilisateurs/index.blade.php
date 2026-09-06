@extends('layouts.app')
@section('title', 'Gestion des Utilisateurs')

@section('sidebar')
<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Administration</p>
</div>
<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-chart-line w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Tableau de bord</span>
    </a>
    <a href="{{ route('admin.users.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-user-shield w-5 text-center text-base {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-purple-400' }}"></i>
        <span>Gestion Utilisateurs</span>
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-user-gear text-indigo-400"></i>
                <span>Gestion des <span class="gradient-text">Utilisateurs</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Gérez les comptes d'accès, rôles et réinitialisations de mot de passe</p>
        </div>
    </div>

    {{-- Temp Password Alert --}}
    @if(session('temp_password'))
    <div class="glass-panel border border-amber-500/30 rounded-2xl p-5 shadow-2xl relative overflow-hidden space-y-3">
        <div class="flex items-center gap-2 text-amber-400 font-bold text-base">
            <i class="fa-solid fa-key"></i> Mot de passe temporaire généré
        </div>
        <p class="text-slate-300 text-sm">
            Compte concerné : <strong class="text-white">{{ session('reset_user') }}</strong>
        </p>
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-xs text-slate-400 uppercase font-semibold">Nouveau mot de passe :</span>
            <code id="tempPwd" class="bg-slate-900 border border-slate-700 px-3.5 py-1.5 rounded-xl font-mono text-base font-bold text-indigo-300 tracking-widest">
                {{ session('temp_password') }}
            </code>
            <button onclick="copyTempPwd()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs px-3 py-1.5 rounded-lg border border-slate-700 font-medium transition">
                <i class="fa-solid fa-copy mr-1"></i> Copier
            </button>
        </div>
        <p class="text-xs text-slate-400">Ce mot de passe est affiché une seule fois. Transmettez-le à l'utilisateur.</p>
        @if(session('user_phone'))
            @php
                $phone = preg_replace('/\D/', '', session('user_phone'));
                $wa = 'https://wa.me/237' . ltrim($phone, '0') . '?text=' . urlencode('Votre nouveau mot de passe temporaire : ' . session('temp_password') . ' — Connectez-vous sur l\'application Suivi Stagiaires.');
            @endphp
            <a href="{{ $wa }}" target="_blank"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
                <i class="fa-brands fa-whatsapp text-sm"></i> Envoyer via WhatsApp
            </a>
        @endif
    </div>
    @endif

    <!-- Table Container -->
    <div class="glass-panel rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3.5">Matricule</th>
                        <th class="px-4 py-3.5">Nom</th>
                        <th class="px-4 py-3.5">Email</th>
                        <th class="px-4 py-3.5">Rôle</th>
                        <th class="px-4 py-3.5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-mono font-bold text-indigo-400">{{ $user->matricule }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-100">{{ $user->nom }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $user->email ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = [
                                    'admin' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    'encadrant' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                    'stagiaire' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $colors[$user->role] ?? 'bg-slate-800 text-slate-300' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.users.reset_password', $user) }}" method="POST"
                                  onsubmit="return confirm('Réinitialiser le mot de passe de {{ addslashes($user->nom) }} ?')">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 text-xs font-semibold px-3 py-1.5 rounded-lg border border-amber-500/20 transition">
                                    <i class="fa-solid fa-key"></i> Réinitialiser mdp
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 opacity-30 block"></i>
                            <p class="text-sm font-medium">Aucun utilisateur.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyTempPwd() {
    const pwd = document.getElementById('tempPwd').innerText.trim();
    navigator.clipboard.writeText(pwd).then(() => alert('Mot de passe copié !'));
}
</script>
@endpush

