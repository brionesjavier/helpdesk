<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-700 rounded-md p-4 mb-4 shadow-sm">
                <span class="text-indigo-600 dark:text-indigo-300 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Users
            </h2>
        </div>
    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('users.index') }}" class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                        <div class="flex flex-wrap gap-4 items-center">
                            <!-- Campo de búsqueda -->
                            <div class="flex-1 min-w-[150px]">
                                <x-input-label for="search" :value="__('Buscar')" />
                                <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, Apellido, Email, Teléfono, ID"/>
                            </div>

                            <!-- Rol -->
                            <div class="flex-none min-w-[120px]">
                                <x-input-label for="role" :value="__('Rol')" />
                                <select id="role" name="role"
                                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                    <option value="">Todos</option>
                                    @foreach (Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Asignable -->
                            <div class="flex-none min-w-[120px]">
                                <x-input-label for="assignable" :value="__('Asignable')" />
                                <select id="assignable" name="assignable"
                                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('assignable') == '1' ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ request('assignable') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <!-- Botones de Buscar y Limpiar -->
                            <div class="flex space-x-2 mt-4">
                                <x-primary-button class="w-full">
                                    {{ __('Buscar') }}
                                </x-primary-button>
                                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition duration-300 ease-in-out">
                                    {{ __('Limpiar') }}
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de usuarios -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-2 text-gray-200">Id</th>
                                    <th class="px-4 py-2 text-gray-200">Usuario</th>
                                    <th class="px-4 py-2 text-gray-200">Email</th>
                                    <th class="px-4 py-2 text-gray-200">Role Asignado</th>
                                    <th class="px-4 py-2 text-gray-200">Asignable</th>
                                    <th class="px-4 py-2 text-gray-200">Fecha de Creación</th>
                                    <th class="px-4 py-2 text-gray-200">Fecha de Actualización</th>
                                    <th class="px-4 py-2 text-gray-200">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $index => $user)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-50 dark:bg-gray-800' }} hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <td class="px-4 py-2">{{ $user->id }}</td>
                                        <td class="px-4 py-2" title="{{ $user->first_name }} {{ $user->last_name }}">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td class="px-4 py-2" title="{{ $user->email }}">{{ $user->email }}</td>
                                        <td class="px-4 py-2">{{ $user->roles->pluck('name')->join(', ') }}</td>
                                        <td class="px-4 py-2">{{ $user->assignable ? 'Sí' : 'No' }}</td>
                                        <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">{{ $user->updated_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            @can('users.show')
                                                <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:text-blue-700">Ver</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                            ¡No existen usuarios almacenados!
                                        </td

>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>