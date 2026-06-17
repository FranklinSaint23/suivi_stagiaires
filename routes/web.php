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

// Redirection racine
Route::get('/', fn() => redirect()->route('login'));

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
