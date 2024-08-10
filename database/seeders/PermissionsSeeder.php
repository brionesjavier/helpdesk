<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos para requerimientos
    Permission::create(['name' => 'crear requerimientos']);
    Permission::create(['name' => 'ver requerimientos propios']);
    Permission::create(['name' => 'ver todos los requerimientos']);
    Permission::create(['name' => 'editar requerimientos propios']);
    Permission::create(['name' => 'editar todos los requerimientos']);
    Permission::create(['name' => 'eliminar requerimientos propios']);
    Permission::create(['name' => 'eliminar todos los requerimientos']);
    Permission::create(['name' => 'asignar requerimientos']);
    Permission::create(['name' => 'cambiar estado de requerimientos']);
    Permission::create(['name' => 'agregar comentarios a requerimientos']);
    Permission::create(['name' => 'ver historial de requerimientos']);

    // Permisos para usuarios y roles
    Permission::create(['name' => 'ver usuarios']);
    Permission::create(['name' => 'crear usuarios']);
    Permission::create(['name' => 'editar usuarios']);
    Permission::create(['name' => 'eliminar usuarios']);
    Permission::create(['name' => 'asignar roles']);
    Permission::create(['name' => 'gestionar roles y permisos']);

    // Permisos para categorías y elementos
    Permission::create(['name' => 'ver categorías']);
    Permission::create(['name' => 'crear categorías']);
    Permission::create(['name' => 'editar categorías']);
    Permission::create(['name' => 'eliminar categorías']);
    Permission::create(['name' => 'gestionar elementos']);
    }
}
