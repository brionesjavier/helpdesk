


<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Asignar Roles a Usuario
            </h2>
            @can('users.manageRoles')
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="{{ route('users.manageRoles', $user)}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Asignar/Editar Roles') }}</a>
                </div>
            </div>
            @endcan
        </div>

    </x-slot>

        {{-- El contenido principal de la página --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{-- aqui el codigo --}}

                        
   
                        <h1>Detalles del Usuario</h1>
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        
                        <h2>Roles Asignados:</h2>
                      
                        <ul>
                            @forelse ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @empty
                                <li>El usuario no tiene roles asignados.</li>
                            @endforelse
                        </ul>
                    
                     
                    
                </div>
            </div>
        </div>
</x-app-layout>