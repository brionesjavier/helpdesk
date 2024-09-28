<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $assignable = $request->input('assignable'); // Parámetro para asignable
    
        // Construir la consulta base
        $query = User::query();
    
        // Aplicar búsqueda por nombre, apellido, email, teléfono e id
        if ($search) {
            $query->where(function ($q) use ($search) {

                // Verifica si es un correo electrónico con al menos 4 caracteres
                if (filter_var($search, FILTER_VALIDATE_EMAIL) && strlen($search) >= 4) {
                    $q->orWhere('email', 'like', "%$search%");
                }
    
                // Verifica si es un nombre, apellido o ID
                if (!is_numeric($search) || strlen($search) < 6) {
                    $q->orWhere('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
                }
    
                // Verifica si es un ID
                if (is_numeric($search) && strlen($search) < 6) {
                    $q->orWhere('id', $search);
                }
            });
        }
    
        // Filtrar por rol
        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }
    
        // Filtrar por assignable
        if ($assignable !== null) {
            $query->where('assignable', $assignable);
        }
    
        // Paginación
        $users = $query->paginate(10);
    
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
            'birthdate'=>'required|date|before_or_equal:'.date('Y-m-d'),
            'address'=>'string',
            'city'=>'string',
            'assignable' => 'required|boolean',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'city' => $request->city,
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
