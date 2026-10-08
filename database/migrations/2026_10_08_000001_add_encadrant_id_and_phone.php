<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Stagiaire;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add telephone to users table if not exists
        if (!Schema::hasColumn('users', 'telephone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('telephone', 30)->nullable()->after('email');
            });
        }

        // 2. Add encadrant_id to stagiaires table if not exists
        if (!Schema::hasColumn('stagiaires', 'encadrant_id')) {
            Schema::table('stagiaires', function (Blueprint $table) {
                $table->foreignId('encadrant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->onDelete('set null');
            });
        }

        // 3. Add encadrant_id to demandes_stage table if not exists
        if (!Schema::hasColumn('demandes_stage', 'encadrant_id')) {
            Schema::table('demandes_stage', function (Blueprint $table) {
                $table->foreignId('encadrant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->onDelete('set null');
            });
        }

        // 4. Assign existing stagiaires to first encadrant if available
        $firstEncadrant = User::where('role', 'encadrant')->first();
        if ($firstEncadrant) {
            Stagiaire::whereNull('encadrant_id')->update(['encadrant_id' => $firstEncadrant->id]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('demandes_stage', 'encadrant_id')) {
            Schema::table('demandes_stage', function (Blueprint $table) {
                $table->dropForeign(['encadrant_id']);
                $table->dropColumn('encadrant_id');
            });
        }

        if (Schema::hasColumn('stagiaires', 'encadrant_id')) {
            Schema::table('stagiaires', function (Blueprint $table) {
                $table->dropForeign(['encadrant_id']);
                $table->dropColumn('encadrant_id');
            });
        }

        if (Schema::hasColumn('users', 'telephone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('telephone');
            });
        }
    }
};
