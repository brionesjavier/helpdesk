<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear los permisos
        $permissions = [
            'roles.index' => 'Ver lista de roles.',
            'roles.create' => 'Crear nuevo rol.',
            'roles.store' => 'Guardar rol nuevo.',
            'roles.edit' => 'Editar rol existente.',
            'roles.update' => 'Actualizar rol.',
            'roles.destroy' => 'Eliminar rol.',
            'users.index' => 'Ver lista de usuarios.',
            'users.search'=>'Ver formulario de busqueda para lista de usuarios .',
            'users.show' => 'Ver detalles de usuario.',
            'users.edit' => 'Editar usuario existente.',
            'users.update' => 'Actualizar usuario.',
            'users.manageRoles' => 'Asignar y Editar roles de usuario.',
            'users.updateRoles' => 'Actualizar roles de usuario.',
            'categories.index' => 'Ver lista de categorías.',
            'categories.create' => 'Crear nueva categoría.',
            'categories.store' => 'Guardar nueva categoría.',
            'categories.edit' => 'Editar categoría existente.',
            'categories.update' => 'Actualizar categoría.',
            'categories.show' => 'Ver detalles de categoría.',
            'categories.destroy' => 'Eliminar categoría.',
            'elements.index' => 'Ver lista de elementos.',
            'elements.create' => 'Crear nuevo elemento.',
            'elements.store' => 'Guardar nuevo elemento.',
            'elements.show' => 'Ver detalles de elemento.',
            'elements.edit' => 'Editar elemento existente.',
            'elements.update' => 'Actualizar elemento.',
            'elements.destroy' => 'Eliminar elemento.',
            'states.index' => 'Ver lista de estados.',
            'states.store' => 'Guardar nuevo estado.',
            'states.show' => 'Ver detalles de estado.',
            'states.edit' => 'Editar estado existente.',
            'states.update' => 'Actualizar estado.',
            'tickets.index' => 'Ver lista de todos los tickets.',
            'tickets.search' => 'Ver formulario de busqueda para lista de todos tickets.',
            'tickets.create' => 'Crear nuevo ticket.',
            'tickets.store' => 'Guardar nuevo ticket.',
            'tickets.show' => 'Ver detalles de ticket.',
            'tickets.edit' => 'Editar ticket existente.',
            'tickets.update' => 'Actualizar ticket.',
            'tickets.destroy' => 'Eliminar ticket.',
            'comments.store' => 'Agregar comentario a ticket.',
            'comments.index' => 'Ver comentarios de ticket.',
            'history.index' => 'Ver historial de tickets.',
            'tickets.my' => 'Ver formulario de busqueda en historial mis tickets.',
            'tickets.my.search' => 'Ver mis tickets.',
            'histories.my' => 'Ver mi historial.',
            'histories.my.search' => 'Ver formulario de busqueda en historial',
            'tickets.process'=>'Comenzar Proceso',
            'tickets.process.submit'=>'Formulario para comenzar el proceso',
            'tickets.solve' => 'Formulario para solucionar ticket.',
            'tickets.solve.submit' => 'Resolver ticket.',
            'tickets.derive' => 'Formulario para derivar ticket.',
            'tickets.derive.submit' => 'Derivar ticket.',
            'tickets.close' => 'Formulario para cerrar ticket.',
            'tickets.close.submit' => 'Cerrar ticket.',
            'tickets.reopen' => 'Formulario para reabrir ticket.',
            'tickets.reopen.submit' => 'Reabrir ticket.',
            'tickets.cancel' => 'Formulario para cancelar ticket.',
            'tickets.cancel.submit' => 'Cancelar ticket.',
            'support.assigned' => 'Bandeja de soporte ',
            'support.store' => 'Asignar a soporte',
            'support.show' => 'formulario para asignar a soporte',
            'support.index' => 'ver tickets para asignar a soporte',
            'support.search' => 'formulario de busqueda para  soporte',
            'support.center'=> 'bandeja de tickets sin asignar',
            'reports.tickets'=>'reporte de datos de tickets',
            'reports.summary'=>'reporte de datos de tickets con resumen de tickets por estado',

        ];

        // Crear o actualizar los permisos
        foreach ($permissions as $name => $description) {
            Permission::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }

        // Definir los roles y asignarles permisos
        $rolesPermissions = [
            'admin' => [
                'roles.index', 'roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.destroy',
                'users.index', 'users.show', 'users.update','users.manageRoles', 'users.updateRoles',
                'categories.index', 'categories.create', 'categories.store', 'categories.edit', 'categories.update', 'categories.show', 'categories.destroy',
                'elements.index', 'elements.create', 'elements.store', 'elements.show', 'elements.edit', 'elements.update', 'elements.destroy',
                'states.index', 'states.store', 'states.show', 'states.edit', 'states.update',
                'tickets.index', 'tickets.create', 'tickets.store', 'tickets.show', 'tickets.edit', 'tickets.update', 'tickets.destroy',
                'comments.store', 'comments.index', 'history.index',
                'support.assigned','support.store', 'support.show', 'support.index',
                'tickets.my', 'histories.my', 'tickets.solve', 'tickets.solve.submit',
                'tickets.derive', 'tickets.derive.submit', 'tickets.close', 'tickets.close.submit',
                'tickets.reopen', 'tickets.reopen.submit', 'users.edit',
                'tickets.cancel', 'tickets.cancel.submit',
            ],
            'user' => [
                'tickets.my', 'histories.my', 'tickets.create', 'tickets.store',
                'tickets.show', 'comments.store', 'comments.index','categories.show',
                'tickets.cancel', 'tickets.cancel.submit',
            ],
            'support' => [
                'tickets.index', 'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit',
                'tickets.close', 'tickets.close.submit', 'tickets.reopen', 'tickets.reopen.submit',
                 'tickets.cancel', 'tickets.cancel.submit',
                'history.index', 'comments.index', 'comments.store',
            ],
        ];

        // Crear roles si no existen y asignarles permisos
        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
