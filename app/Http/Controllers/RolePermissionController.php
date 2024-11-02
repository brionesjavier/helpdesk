<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index() {
        $roles = Role::paginate();
        return view('roles.index', compact('roles'));
    }

    public function create() {
        $permissions = Permission::orderby('name')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        // Crear el nuevo rol
        $role = Role::create(['name' => $validatedData['name']]);
    
        // Asignar los permisos seleccionados al rol
        if ($request->has('permissions')) {
            $role->permissions()->sync($validatedData['permissions']);
        }
    
        return redirect()->route('roles.index')->with('message', 'Role creado exitosamente.');
    }

    public function edit(Role $role) {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        // Encontrar el rol existente
        $role = Role::findOrFail($id);
    
        // Actualizar el nombre del rol
        $role->update(['name' => $validatedData['name']]);
    
        // Sincronizar los permisos seleccionados con el rol
        if ($request->has('permissions')) {
            $role->permissions()->sync($validatedData['permissions']);
        } else {
            // Si no se seleccionó ningún permiso, se eliminan todos los permisos asociados
            $role->permissions()->sync([]);
        }
    
        return redirect()->route('roles.index')->with('message', 'Role actualizado exitosamente.');
    }
    

    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Role eliminado exitosamente.');
    }
}
