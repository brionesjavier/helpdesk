<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Define the roles
        $roles = [
            'Administrador del Sistema',
            'Administrador de Usuarios',
            'Soporte Técnico',
            'Agente de Soporte',
            'Gerente de Categorías y Elementos',
            'Usuario Básico',
            'Supervisor de Tickets',
            'Analista de Reportes',
        ];

        // Create the permissions
        $permissions = [
            // Roles
            'roles.index',
            'roles.create',
            'roles.store',
            'roles.edit',
            'roles.update',
            'roles.destroy',

            // Users
            'users.index',
            'users.search',
            'users.show',
            'users.edit',
            'users.update',
            'users.manageRoles',
            'users.updateRoles',

            // Categories
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.edit',
            'categories.update',
            'categories.show',
            'categories.destroy',

            // Elements
            'getElements',
            'elements.index',
            'elements.create',
            'elements.store',
            'elements.show',
            'elements.edit',
            'elements.update',
            'elements.destroy',

            // States
            'states.index',
            'states.store',
            'states.show',
            'states.edit',
            'states.update',

            // Tickets
            'tickets.index',
            'tickets.search',
            'tickets.create',
            'tickets.store',
            'tickets.show',
            'tickets.edit',
            'tickets.update',
            'tickets.destroy',
            'tickets.my',
            'tickets.my.search',
            'tickets.process',
            'tickets.process.submit',
            'tickets.solve',
            'tickets.solve.submit',
            'tickets.derive',
            'tickets.derive.submit',
            'tickets.close',
            'tickets.close.submit',
            'tickets.reopen',
            'tickets.reopen.submit',
            'tickets.cancel',
            'tickets.cancel.submit',

            // Comments
            'comments.store',
            'comments.index',

            // History
            'history.index',
            'histories.my',
            'histories.my.search',

            // Support
            'support.assigned',
            'support.store',
            'support.show',
            'support.index',
            'support.search',
            'support.center',

            // Reports
            'reports.tickets',
            'reports.summary',
        ];

        // Create or update each permission in the system
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Define the permissions for each role
        $rolePermissions = [
            'Administrador del Sistema' => $permissions,
            'Administrador de Usuarios' => [
                'users.index', 'users.search', 'users.show', 'users.edit', 'users.update', 'users.manageRoles', 'users.updateRoles',
                'roles.index', 'roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.destroy'
            ],
            'Soporte Técnico' => [
                'tickets.index', 'tickets.show', 'tickets.process', 'tickets.process.submit', 'tickets.solve', 'tickets.solve.submit',
                'tickets.derive', 'tickets.derive.submit', 'tickets.close', 'tickets.close.submit', 'tickets.reopen', 'tickets.reopen.submit',
                'comments.store', 'comments.index', 'support.assigned', 'support.store', 'support.show', 'support.index', 'support.search',
            ],
            'Agente de Soporte' => [
                'tickets.index', 'tickets.show', 'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit', 'comments.store',
            ],
            'Gerente de Categorías y Elementos' => [
                'categories.index', 'categories.create', 'categories.store', 'categories.edit', 'categories.update', 'categories.show', 'categories.destroy',
                'elements.index', 'elements.create', 'elements.store', 'elements.show', 'elements.edit', 'elements.update', 'elements.destroy',
            ],
            'Usuario Básico' => [
                'tickets.my', 'tickets.my.search', 'tickets.create', 'tickets.store', 'tickets.show', 'comments.store', 'history.index', 'histories.my', 'histories.my.search','getElements'
            ],
            'Supervisor de Tickets' => [
                'tickets.index', 'tickets.show', 'support.center', 'support.store', 'reports.tickets', 'reports.summary',
            ],
            'Analista de Reportes' => [
                'reports.tickets', 'reports.summary',
            ],
        ];

        // Create or update the roles and assign the permissions
        foreach ($rolePermissions as $roleName => $rolePerms) {
            // Create or update the role
            $role = Role::updateOrCreate(['name' => $roleName]);

            // Sync the permissions for the role (this will update the permissions if they already exist)
            $role->syncPermissions($rolePerms);
        }
    }
}
