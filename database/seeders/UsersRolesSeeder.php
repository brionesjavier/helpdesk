<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verificar que los roles ya existen
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Crear el usuario root si no existe
        $user = User::firstOrCreate([
            'email' => 'root@gmail.com',
        ], [
            'first_name' => 'Root ',
            'last_name' => 'Admin',
            'password' => Hash::make('password'), // Cambia por tu contraseña deseada
        ]);

        // Asignar roles al usuario
        $user->assignRole($adminRole);
        $user->assignRole($userRole);
    }
}
