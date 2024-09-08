<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar/Asignar Roles a Usuario: {{ $user->first_name }} {{ $user->last_name }}
            </h2>
            @can('users.index')
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100 space-x-8">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                        {{ __('Cancelar') }}
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Información del Usuario --}}
                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold mb-2">Usuario: {{ $user->first_name }} {{ $user->last_name }}</h1>
                    </div>

                    {{-- Formulario de Roles --}}
                    @can('users.updateRoles')
                    <form action="{{ route('users.updateRoles', $user->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="space-y-4">
                            @foreach ($roles as $role)
                                <div class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->name }}" 
                                        id="role-{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                    >
                                    <label for="role-{{ $role->id }}" class="text-gray-700 dark:text-gray-300">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Actualizar/Asignar') }}
                            </x-primary-button>
                        </div>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
