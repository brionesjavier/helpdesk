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
                Asignar Roles a Usuario
            </h2>
            @canany(['users.manageRoles', 'users.edit'])
                <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-4 text-gray-900 dark:text-gray-100 space-x-8">
                        @can('users.edit')
                            <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                {{ __('Editar usuario') }}
                            </a>
                        @endcan

                        @can('users.manageRoles')
                            <a href="{{ route('users.manageRoles', $user) }}" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                {{ __('Asignar/Editar Roles') }}
                            </a>
                        @endcan
                    </div>
                </div>
            @endcanany
        </div>
    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <!-- Información del Usuario -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md shadow-md">
                        <h1 class="text-2xl font-semibold mb-4">Detalles del Usuario</h1>
                        <div class="space-y-4">
                            <p><strong>Nombre:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Teléfono:</strong> {{ $user->phone ?? 'No proporcionado' }}</p>
                            <p><strong>Dirección:</strong> {{ $user->address ?? 'No proporcionada' }}</p>
                            <p><strong>Ciudad:</strong> {{ $user->city ?? 'No proporcionada' }}</p>
                            <p><strong>Fecha de Nacimiento:</strong> {{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') : 'No proporcionada' }}</p>
                            <p><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Fecha de Actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Asignable:</strong> {{ $user->is_assignable ? 'Sí' : 'No' }}</p>
                        </div>
                    </div>

                    <!-- Roles Asignados -->
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-md shadow-md">
                        <h2 class="text-lg font-semibold mb-2">Roles Asignados:</h2>
                        <ul class="list-disc list-inside">
                            @forelse ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @empty
                                <li>El usuario no tiene roles asignados.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Botón para Volver -->
                    <div class="mt-6">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:hover:bg-gray-700">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
