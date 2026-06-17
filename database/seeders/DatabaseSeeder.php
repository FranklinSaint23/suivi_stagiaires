<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['matricule' => 'ADMIN001'], [
            'nom'      => 'Administrateur',
            'email'    => 'admin@suivi.cm',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        User::firstOrCreate(['matricule' => 'ENC001'], [
            'nom'      => 'Encadrant Principal',
            'email'    => 'encadrant@suivi.cm',
            'password' => bcrypt('enc123'),
            'role'     => 'encadrant',
        ]);
    }
}
