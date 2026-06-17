<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->enum('sexe', ['M', 'F']);
            $table->string('nom');
            $table->string('prenom');
            $table->date('naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('lieu')->nullable();
            $table->string('filiere')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
