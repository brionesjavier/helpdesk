<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Detalles del Estado</h2>
                
                <div class="mb-4">
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">Nombre: 
                        <span class="font-normal">{{ $state->name }}</span>
                    </p>
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">Estado: 
                        <span class="font-normal">{{ $state->is_active ? 'On' : 'Off' }}</span>
                    </p>
                    <p class="text-2xl font-medium text-gray-800 dark:text-gray-200">Creado: 
                        <span class="font-normal">{{ $state->created_at->format('Y-m-d H:i:s') }}</span>
                    </p>
                </div>

                <div class="flex space-x-4">
                    @can('states.edit')
                        <a href="{{ route('states.edit', $state) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                            Editar
                        </a>
                    @endcan

                    @can('states.destroy')
                        <form action="{{ route('states.destroy', $state) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estado?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
