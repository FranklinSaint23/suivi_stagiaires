<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EncadrantController;
use App\Http\Controllers\StagiaireDashboardController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\DemandeStageController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\GeolocationController;
use App\Http\Controllers\AiController;
use Illuminate\Support\Facades\Route;

// Redirection racine intelligente selon le rôle de l'utilisateur connecté
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'encadrant' => redirect()->route('encadrant.dashboard'),
            'stagiaire' => redirect()->route('stagiaire.dashboard'),
            default     => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// Serveur de fichiers uploadés (bypass symlink & résolution multi-chemins)
Route::get('/fichier/{path}', function (string $path) {
    $cleanPath = ltrim(str_replace('storage/', '', $path), '/');

    $possiblePaths = [
        storage_path('app/public/' . $cleanPath),
        public_path('storage/' . $cleanPath),
        public_path($cleanPath),
        storage_path('app/' . $cleanPath),
    ];

    foreach ($possiblePaths as $fullPath) {
        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->file($fullPath);
        }
    }

    $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">
            <defs>
                <linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#4f46e5"/>
                    <stop offset="100%" stop-color="#7c3aed"/>
                </linearGradient>
            </defs>
            <rect width="128" height="128" rx="64" fill="url(#g)"/>
            <path d="M64 36 a18 18 0 1 0 0.1 0 Z M36 94 c0-15 12-26 28-26 s28 11 28 26 Z" fill="#ffffff" opacity="0.9"/>
        </svg>';
        return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
    }

    abort(404, 'Fichier introuvable sur le serveur.');
})->where('path', '.*')->name('fichier');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Demande de stage publique
Route::get('/demande-stage', [DemandeStageController::class, 'publicForm'])->name('demande.form');
Route::post('/demande-stage', [DemandeStageController::class, 'publicStore'])->name('demande.store');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/utilisateurs', [AdminController::class, 'users'])->name('users.index');
    Route::post('/utilisateurs/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.reset_password');
});

// Encadrant
Route::middleware(['auth', 'role:encadrant'])->prefix('encadrant')->name('encadrant.')->group(function () {
    Route::get('/dashboard', [EncadrantController::class, 'dashboard'])->name('dashboard');

    // Stagiaires
    Route::resource('stagiaires', StagiaireController::class);

    // Stages
    Route::resource('stages', StageController::class)->except(['show']);

    // Demandes de stage
    Route::get('/demandes', [DemandeStageController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/{demande}', [DemandeStageController::class, 'show'])->name('demandes.show');
    Route::post('/demandes/{demande}/accepter', [DemandeStageController::class, 'accept'])->name('demandes.accept');
    Route::post('/demandes/{demande}/refuser', [DemandeStageController::class, 'refuse'])->name('demandes.refuse');

    // Présences
    Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
    Route::get('/presences/pointer', [PresenceController::class, 'create'])->name('presences.create');
    Route::post('/presences', [PresenceController::class, 'store'])->name('presences.store');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}/repondre', [MessageController::class, 'reply'])->name('messages.reply');

    // PDF
    Route::get('/pdf/attestation', [PdfController::class, 'choixAttestation'])->name('pdf.choix_attestation');
    Route::get('/pdf/attestation/{stagiaire}', [PdfController::class, 'attestation'])->name('pdf.attestation');
    Route::get('/pdf/carte', [PdfController::class, 'choixCarte'])->name('pdf.choix_carte');
    Route::get('/pdf/carte/{stagiaire}', [PdfController::class, 'carte'])->name('pdf.carte');
    Route::get('/pdf/presences', [PdfController::class, 'presences'])->name('pdf.presences');

    // Carte interactive
    Route::get('/carte-interactive', [GeolocationController::class, 'index'])->name('carte_interactive');

    // IA
    Route::post('/ai/analyse-cv/{demande}', [AiController::class, 'analyseCv'])->name('ai.analyse_cv');
    Route::post('/ai/rapport/{stagiaire}', [AiController::class, 'rapportPerformance'])->name('ai.rapport');
    Route::post('/ai/anomalies', [AiController::class, 'detecterAnomalies'])->name('ai.anomalies');
});

// Stagiaire
Route::middleware(['auth', 'role:stagiaire'])->prefix('stagiaire')->name('stagiaire.')->group(function () {
    Route::get('/dashboard', [StagiaireDashboardController::class, 'index'])->name('dashboard');
    Route::post('/messages', [MessageController::class, 'storeFromStagiaire'])->name('messages.store');
    Route::get('/pdf/presences', [PdfController::class, 'presences'])->name('pdf.presences');
    Route::get('/geolocaliser', [GeolocationController::class, 'myLocation'])->name('geolocaliser');
    Route::post('/position', [GeolocationController::class, 'save'])->name('position.save');

    // IA chatbot
    Route::post('/ai/chat', [AiController::class, 'chatStagiaire'])->name('ai.chat');
});
