<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function showAssignForm()
    {
        $users = User::all();
        $roles = Role::all();
        return view('roles.assign', compact('users', 'roles'));
    }

 

    // Método para mostrar el formulario de edición de roles
    public function editRoles($id)
    {
        $user = User::findOrFail($id); // Obtener el usuario por ID
        $roles = Role::all(); // Obtener todos los roles disponibles

        // Retornar la vista con los datos del usuario y los roles
        return view('roles.editRoles', compact('user', 'roles'));
    }

    // Método para actualizar los roles del usuario
    public function updateRoles(Request $request, $id)
    {
        $user = User::findOrFail($id); // Obtener el usuario por ID

        // Sincronizar los roles seleccionados con los roles del usuario
        $user->syncRoles($request->input('roles', []));

        // Redirigir de nuevo al formulario con un mensaje de éxito
        return redirect()->route('users.editRoles', $user->id)->with('success', 'Roles actualizados correctamente.');
    }
}
