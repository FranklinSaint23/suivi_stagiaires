<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_stage', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->enum('sexe', ['M', 'F']);
            $table->string('photo')->nullable();
            $table->string('lieu')->nullable();
            $table->string('filiere')->nullable();
            $table->string('telephone')->nullable();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('cv')->nullable();
            $table->string('lettre')->nullable();
            $table->string('certificat')->nullable();
            $table->enum('etat', ['En attente', 'Validée', 'Refusée'])->default('En attente');
            $table->string('mot_de_passe')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_stage');
    }
};
