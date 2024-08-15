<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function index()
    {
        $users= User::all();

        return view('users.index',compact('users'));
    }

    public function assignRoles(Request $request,User $user)
    {
        $request->validate([
            'roles' => 'array|exists:roles,name',
        ]);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('message', 'Roles asignados correctamente.');
    }

       // Muestra la información del usuario y sus roles
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Muestra el formulario para gestionar roles (editar o asignar)
public function manageRoles($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all(); // Obtener todos los roles disponibles
    return view('users.manageRoles', compact('user', 'roles'));
}

// Actualiza los roles del usuario (editar o asignar)
public function updateRoles(Request $request, $id)
{
    $user = User::findOrFail($id);
    $roles = $request->input('roles', []); // Obtener roles seleccionados
    
    // Sincronizar roles del usuario (puede ser assignRole o syncRoles según el caso)
    $user->syncRoles($roles);

    return redirect()->route('users.show', $id)->with('message', 'Roles actualizados con éxito.');
}

public function edit(User $user){
    return view('users.edit', compact('user'));

}

public function update(Request $request,User $user){

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'assignable' => 'required|boolean',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'assignable' => $request->assignable,
        ]);

        $user->save();

        return redirect()->route('users.index')->with('message', 'Usuario actualizado con éxito.');
}





}





