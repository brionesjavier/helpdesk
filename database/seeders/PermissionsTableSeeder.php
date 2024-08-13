<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'roles.index' => 'Ver lista de roles.',
            'roles.create' => 'Crear nuevo rol.',
            'roles.store' => 'Guardar rol nuevo.',
            'roles.edit' => 'Editar rol existente.',
            'roles.update' => 'Actualizar rol.',
            'roles.destroy' => 'Eliminar rol.',
            'users.index' => 'Ver lista de usuarios.',
            'users.show' => 'Ver detalles de usuario.',
            'users.manageRoles' => 'Asignar y Editar roles de usuario.',
            'users.updateRoles' => 'Actualizar roles de usuario.',
            'categories.index' => 'Ver lista de categorías.',
            'categories.create' => 'Crear nueva categoría.',
            'categories.store' => 'Guardar nueva categoría.',
            'categories.edit' => 'Editar categoría existente.',
            'categories.update' => 'Actualizar categoría.',
            'getElements' => 'Obtener elementos de categoría.',
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
            'tickets.index' => 'Ver lista de tickets.',
            'tickets.create' => 'Crear nuevo ticket.',
            'tickets.store' => 'Guardar nuevo ticket.',
            'tickets.show' => 'Ver detalles de ticket.',
            'tickets.edit' => 'Editar ticket existente.',
            'tickets.update' => 'Actualizar ticket.',
            'tickets.destroy' => 'Eliminar ticket.',
            'comments.store' => 'Agregar comentario a ticket.',
            'comments.index' => 'Ver comentarios de ticket.',
            'history.index' => 'Ver historial de tickets.',
            'tickets.my' => 'Ver mis tickets.',
            'histories.my' => 'Ver mi historial.',
            'tickets.solve' => 'Formulario para solucionar ticket.',
            'tickets.solve.submit' => 'Resolver ticket.',
            'tickets.derive' => 'Formulario para derivar ticket.',
            'tickets.derive.submit' => 'Derivar ticket.',
            'tickets.close' => 'Formulario para cerrar ticket.',
            'tickets.close.submit' => 'Cerrar ticket.',
            'tickets.reopen' => 'Formulario para reabrir ticket.',
            'tickets.reopen.submit' => 'Reabrir ticket.',
            'tickets.program' => 'Formulario para programar ticket.',
            'tickets.program.submit' => 'Programar ticket.',
            'tickets.cancel' => 'Formulario para cancelar ticket.',
            'tickets.cancel.submit' => 'Cancelar ticket.',
        ];

        foreach ($permissions as $name => $description) {
            Permission::create(['name' => $name, 'description' => $description]);
        }
    }
}
