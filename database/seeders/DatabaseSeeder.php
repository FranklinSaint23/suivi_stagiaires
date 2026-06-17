<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom'       => 'Administrateur',
            'matricule' => 'ADMIN001',
            'email'     => 'admin@suivi.cm',
            'password'  => bcrypt('admin123'),
            'role'      => 'admin',
        ]);

        User::create([
            'nom'       => 'Encadrant Principal',
            'matricule' => 'ENC001',
            'email'     => 'encadrant@suivi.cm',
            'password'  => bcrypt('enc123'),
            'role'      => 'encadrant',
        ]);
    }
}
