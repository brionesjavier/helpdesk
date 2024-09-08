<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles del Elemento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <p class="text-lg font-medium">Categoría: <span class="font-normal">{{ $element->category->name }}</span></p>
                        <p class="text-lg font-medium">Elemento: <span class="font-normal">{{ $element->name }}</span></p>
                        <p class="text-lg font-medium">Descripción: <span class="font-normal">{{ $element->description }}</span></p>
                        <p class="text-lg font-medium">Creado: <span class="font-normal">{{ $element->created_at->format('Y-m-d H:i:s') }}</span></p>
                        <p class="text-lg font-medium">Estado: <span class="font-normal">{{ $element->is_active ? 'Activo' : 'Inactivo' }}</span></p>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        @can('elements.edit')
                            <a href="{{ route('elements.edit', $element) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md shadow-sm">Editar</a>
                        @endcan

                        @can('elements.destroy')
                            <form action="{{ route('elements.destroy', $element) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este elemento?');">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md shadow-sm">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
