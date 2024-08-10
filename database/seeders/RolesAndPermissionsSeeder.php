<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear roles
        $role = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        // Crear permisos
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        
        // Asignar permisos al rol
        $role->givePermissionTo('view users');
        $role->givePermissionTo('edit users');
    }
}
