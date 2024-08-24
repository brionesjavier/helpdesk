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
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Usuario 2
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Puedes agregar más usuarios de prueba de la misma manera
        // Usuario 3
        User::create([
            'name' => 'camilo ',
            'email' => 'root@root.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'jose ',
            'email' => 'josee@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}

