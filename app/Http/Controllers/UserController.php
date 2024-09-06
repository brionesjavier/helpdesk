<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index():View
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }


    // Muestra la información del usuario y sus roles
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|regex:/^\d{9}$/',
            'assignable' => 'required|boolean',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'assignable' => $request->assignable,
        ]);

        return redirect()->route('users.index')->with('message', 'Usuario actualizado con éxito.');
    }

    // Muestra el formulario para gestionar roles 
    public function manageRoles($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Obtener todos los roles 
        return view('users.manageRoles', compact('user', 'roles'));
    }

    public function assignRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array|exists:roles,name',
        ]);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('message', 'Roles asignados correctamente.');
    }

    // Actualiza los roles del usuario 
    public function updateRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = $request->input('roles', []); // Obtener roles seleccionados

        $user->syncRoles($roles); //asignando roles 

        return redirect()->route('users.show', $id)->with('message', 'Roles actualizados con éxito.');
    }

  
}
