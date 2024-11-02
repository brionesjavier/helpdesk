<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mx-auto px-4 py-6">
                        {{-- Mensajes de error --}}
                   {{--      @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <strong class="font-bold">Whoops!</strong>
                                <span class="block sm:inline">Something went wrong:</span>
                                <ul class="list-disc pl-5 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                    
                        @can('roles.update')
                            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-4" onsubmit="return confirm('¿Estás seguro de que deseas actualizar el role?')">
                                @csrf
                                @method('PUT')
                                
                                {{-- Nombre del Rol --}}
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                                    <input type="text" id="name" name="name" value="{{ $role->name }}" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-300 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                {{-- Permisos --}}
                                <div class="mb-4">
                                    
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                                @if($role->permissions->contains($permission)) checked @endif>
                                            <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $permission->name }} - {{ $permission->description }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                
                                {{-- Botón de Actualizar --}}
                                <div class="flex items-center justify-start mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                                    Actualizar Role
                                </button>
                                <a href="javascript:history.back()"
                                class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Volver
                            </a>
                            </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
