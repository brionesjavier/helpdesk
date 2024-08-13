<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Usuario 1
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Usuario 2
        User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Puedes agregar más usuarios de prueba de la misma manera
        // Usuario 3
        User::create([
            'name' => 'javier ',
            'email' => 'javier@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'jose ',
            'email' => 'jose@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
    }
}

