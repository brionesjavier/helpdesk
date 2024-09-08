<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
            <div class="text-center bg-gray-100 rounded-md p-2">
                <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Users
            </h2>
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100 space-x-8">
                    <a href="#" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('boton') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Id</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Usuario</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Email</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Role Asignado</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Fecha de Creación</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Fecha de Actualización</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-50 dark:bg-gray-800' }} hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <td class="border border-gray-400 px-4 py-2">{{ $user->id }}</td>
                                    <td class="border border-gray-400 px-4 py-2" title="{{ $user->first_name }} {{ $user->last_name }}">{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td class="border border-gray-400 px-4 py-2" title="{{ $user->email }}">{{ $user->email }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $user->roles()->count() ? 'Sí' : 'No' }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $user->updated_at->format('Y-m-d') }}</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        @can('users.show')
                                            <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:text-blue-700">Ver</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                        ¡No existen usuarios almacenados!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
