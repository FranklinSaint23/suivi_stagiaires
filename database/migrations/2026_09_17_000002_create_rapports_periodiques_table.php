<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapports_periodiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id')->constrained('stagiaires')->onDelete('cascade');
            $table->foreignId('stage_id')->nullable()->constrained('stages')->onDelete('set null');
            $table->string('titre');
            $table->string('periode')->default('Hebdomadaire'); // Hebdomadaire, Bimensuel, Mensuel
            $table->text('contenu');
            $table->string('fichier')->nullable();
            $table->enum('statut', ['Soumis', 'Validé', 'Correction demandée'])->default('Soumis');
            $table->text('commentaire_encadrant')->nullable();
            $table->text('analyse_ia')->nullable();
            $table->timestamp('date_soumission')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapports_periodiques');
    }
};
