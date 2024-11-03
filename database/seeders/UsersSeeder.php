<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisor=User::create([
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Encriptar la contraseña
        ]);


        $usuario=User::create([
            'first_name' => 'user',
            'last_name' => 'test',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Encriptar la contraseña
        ]);

        $soporte=User::create([
            'first_name' => 'soporte',
            'last_name' => 'test',
            'email' => 'soporte@gmail.com',
            'email_verified_at' => now(),
            'assignable'=>true,
            'password' => Hash::make('password'), // Encriptar la contraseña
        ]);

        $administrador=User::create([
            'first_name' => 'admin',
            'last_name' => 'test',
            'email_verified_at' => now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Encriptar la contraseña
        ]);
        
        // Verificar que los roles ya existen
        $adminRole = Role::where('name', 'administrador')->first();
        $userRole = Role::where('name', 'usuario')->first();
        $soporteRole = Role::where('name', 'agente soporte')->first();
        $supervisorRole = Role::where('name', 'administrador soporte')->first();

        //asignando roles a usuario
        $usuario->assignRole($userRole);
        $soporte->assignRole($soporteRole);
        $soporte->assignRole($userRole);
        $administrador->assignRole($adminRole);
        $supervisor->assignRole($supervisorRole);


    }
}
