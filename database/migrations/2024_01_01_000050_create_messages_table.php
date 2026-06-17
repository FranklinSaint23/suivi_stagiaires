<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id')->constrained('stagiaires')->onDelete('cascade');
            $table->foreignId('encadrant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('message');
            $table->enum('expediteur', ['stagiaire', 'encadrant'])->default('stagiaire');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });

        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->onDelete('cascade');
            $table->text('reponse');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('messages');
    }
};
