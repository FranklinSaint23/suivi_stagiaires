<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-100 leading-tight flex items-center gap-3">
            <i class="fa-solid fa-user-gear text-indigo-400"></i> {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="space-y-6 max-w-4xl">
        <div class="glass-panel p-6 sm:p-8 rounded-2xl shadow-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-2xl shadow-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-2xl shadow-xl border-rose-500/20">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
