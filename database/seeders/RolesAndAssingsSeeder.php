<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndAssingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
    $roleRequester = Role::create(['name' => 'Usuario Básico']);
    $roleAccountAdmin = Role::create(['name' => 'Administrador de Cuenta']);
    $roleSupportAgent = Role::create(['name' => 'Agente de Soporte']);
    $roleSupportAdmin = Role::create(['name' => 'Administrador de Soporte']);
    $roleSupervisor = Role::create(['name' => 'Supervisor']);
    $roleGeneralAdmin = Role::create(['name' => 'Administrador General']);

    // Asignar permisos a "Usuario Básico"
    $roleRequester->givePermissionTo([
        'crear requerimientos',
        'ver requerimientos propios',
        'editar requerimientos propios',
        'eliminar requerimientos propios',
        'agregar comentarios a requerimientos',
    ]);

    // Asignar permisos a "Administrador de Cuenta"
    $roleAccountAdmin->givePermissionTo([
        'ver usuarios',
        'crear usuarios',
        'editar usuarios',
        'eliminar usuarios',
        'asignar roles',
    ]);

    // Asignar permisos a "Agente de Soporte"
    $roleSupportAgent->givePermissionTo([
        'ver todos los requerimientos',
        'editar todos los requerimientos',
        'cambiar estado de requerimientos',
        'agregar comentarios a requerimientos',
        'asignar requerimientos',
    ]);

    // Asignar permisos a "Administrador de Soporte"
    $roleSupportAdmin->givePermissionTo([
        'ver todos los requerimientos',
        'editar todos los requerimientos',
        'eliminar todos los requerimientos',
        'asignar requerimientos',
        'cambiar estado de requerimientos',
        'agregar comentarios a requerimientos',
        'ver historial de requerimientos',
        'gestionar elementos',
        'ver categorías',
        'crear categorías',
        'editar categorías',
        'eliminar categorías',
    ]);

    // Asignar permisos a "Supervisor"
    $roleSupervisor->givePermissionTo([
        'ver todos los requerimientos',
        'ver historial de requerimientos',
        'cambiar estado de requerimientos',
        'gestionar elementos',
    ]);

    // Asignar permisos a "Administrador General"
    $roleGeneralAdmin->givePermissionTo(Permission::all());
    }
}
