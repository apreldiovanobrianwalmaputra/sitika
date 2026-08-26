<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Pelapor Satu',
            'email' => 'pelapor1@demo.local',
            'password' => Hash::make('Magang123!'),
            'role' => 'PELAPOR',
        ]);

        User::create([
            'name' => 'Pelapor Dua',
            'email' => 'pelapor2@demo.local',
            'password' => Hash::make('Magang123!'),
            'role' => 'PELAPOR',
        ]);

        User::create([
            'name' => 'Teknisi TI',
            'email' => 'teknisi@demo.local',
            'password' => Hash::make('Magang123!'),
            'role' => 'TEKNISI',
        ]);
    }
}