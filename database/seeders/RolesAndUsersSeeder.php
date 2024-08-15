<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Crear Permisos
        $permissions = [
            'roles.index' => 'Ver lista de roles.',
            'roles.create' => 'Crear nuevo rol.',
            'roles.store' => 'Guardar rol nuevo.',
            'roles.edit' => 'Editar rol existente.',
            'roles.update' => 'Actualizar rol.',
            'roles.destroy' => 'Eliminar rol.',
            'users.index' => 'Ver lista de usuarios.',
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
            'tickets.cancel' => 'Formulario para cancelar ticket.',
            'tickets.cancel.submit' => 'Cancelar ticket.',
            'support.assigned' => 'Asignado soporte.',
            'support.store' => 'Guardar soporte.',
            'support.show' => 'Mostrar soporte.',
            'support.index' => 'Ver lista de soporte.',
        ];

        foreach ($permissions as $key => $description) {
            // Verificar si el permiso ya existe antes de insertarlo
            if (!DB::table('permissions')->where('name', $key)->exists()) {
                DB::table('permissions')->insert([
                    'name' => $key,
                    'description' => $description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Crear Roles
        $roles = [
            'Administrador General' => [
                'roles.index', 'roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.destroy',
                'users.index', 'users.show', 'users.edit', 'users.update', 'users.manageRoles', 'users.updateRoles',
                'categories.index', 'categories.create', 'categories.store', 'categories.edit', 'categories.update', 'categories.show', 'categories.destroy',
                'elements.index', 'elements.create', 'elements.store', 'elements.show', 'elements.edit', 'elements.update', 'elements.destroy',
                'states.index', 'states.store', 'states.show', 'states.edit', 'states.update',
                'tickets.index', 'tickets.create', 'tickets.store', 'tickets.show', 'tickets.edit', 'tickets.update', 'tickets.destroy',
                'comments.store', 'comments.index',
                'history.index',
                'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit', 'tickets.close', 'tickets.close.submit', 'tickets.reopen', 'tickets.reopen.submit', 'tickets.cancel', 'tickets.cancel.submit',
                'support.index', 'support.show', 'support.store'
            ],
            'Administrador de Soporte' => [
                'tickets.index', 'tickets.show', 'tickets.edit', 'tickets.update', 'tickets.destroy',
                'comments.store', 'comments.index',
                'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit', 'tickets.close', 'tickets.close.submit', 'tickets.reopen', 'tickets.reopen.submit', 'tickets.cancel', 'tickets.cancel.submit',
                'support.index', 'support.show'
            ],
            'Agente de Soporte' => [
                'tickets.my', 'tickets.show', 'tickets.edit', 'tickets.update',
                'comments.store', 'comments.index',
                'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit',
                'histories.my', 'history.index'
            ],
            'Supervisor' => [
                'tickets.index', 'tickets.show', 'tickets.edit', 'tickets.update',
                'tickets.solve', 'tickets.solve.submit', 'tickets.derive', 'tickets.derive.submit', 'tickets.close', 'tickets.close.submit', 'tickets.reopen', 'tickets.reopen.submit',
                'support.index', 'support.show'
            ],
            'Usuario Básico' => [
                'tickets.create', 'tickets.store', 'tickets.my', 'tickets.show',
                'comments.store', 'comments.index',
                'histories.my'
            ],
            'Usuario Invitado' => [
                'tickets.show', // Para tickets públicos o compartidos
                'comments.index' // Si hay comentarios visibles públicamente
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            // Verificar si el rol ya existe antes de insertarlo
            if (!DB::table('roles')->where('name', $roleName)->exists()) {
                DB::table('roles')->insert([
                    'name' => $roleName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $roleId = DB::table('roles')->where('name', $roleName)->value('id');

            foreach ($permissions as $permission) {
                // Verificar si el permiso ya está asignado al rol
                if (!DB::table('role_permission')->where('role_id', $roleId)->where('permission_id', DB::table('permissions')->where('name', $permission)->value('id'))->exists()) {
                    DB::table('role_permission')->insert([
                        'role_id' => $roleId,
                        'permission_id' => DB::table('permissions')->where('name', $permission)->value('id'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Crear Usuarios y Asignar Roles
        $users = [
            ['name' => 'Admin General', 'email' => 'admin.general@example.com', 'password' => 'password', 'role' => 'Administrador General'],
            ['name' => 'Admin Soporte', 'email' => 'admin.soporte@example.com', 'password' => 'password', 'role' => 'Administrador de Soporte'],
            ['name' => 'Agente 1', 'email' => 'agente1@example.com', 'password' => 'password', 'role' => 'Agente de Soporte'],
            ['name' => 'Supervisor', 'email' => 'supervisor@example.com', 'password' => 'password', 'role' => 'Supervisor'],
            ['name' => 'Usuario Básico', 'email' => 'usuario.basico@example.com', 'password' => 'password', 'role' => 'Usuario Básico'],
            ['name' => 'Invitado', 'email' => 'invitado@example.com', 'password' => 'password', 'role' => 'Usuario Invitado'],
        ];

        foreach ($users as $userData) {
            // Verificar si el usuario ya existe antes de crear uno nuevo
            if (!DB::table('users')->where('email', $userData['email'])->exists()) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                ]);

                // Asignar rol al usuario
                $roleId = DB::table('roles')->where('name', $userData['role'])->value('id');
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}