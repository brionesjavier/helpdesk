<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-900 rounded-md p-4 shadow-md mb-4">
                <span class="text-indigo-600 dark:text-indigo-400 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Categorías
            </h2>
            @can('categories.create')
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 ease-in-out">
                    {{ __('Agregar') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Categoría
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Descripción
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Opción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($categories as $index => $category)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-300">
                                        <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $category->name }}</td>
                                        <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $category->description }}</td>
                                        <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700 flex space-x-2">
                                            @can('categories.show')
                                                <a href="{{ route('categories.show', $category) }}" class="inline-flex items-center px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md shadow-sm text-sm font-medium transition duration-300 ease-in-out">Ver</a>
                                            @endcan
                                            @can('categories.edit')
                                                <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center px-3 py-1 text-white bg-yellow-600 hover:bg-yellow-700 border border-transparent rounded-md shadow-sm text-sm font-medium transition duration-300 ease-in-out">Editar</a>
                                            @endcan
                                            @can('categories.destroy')
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar la Categorías ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-white bg-red-600 hover:bg-red-700 border border-transparent rounded-md shadow-sm text-sm font-medium transition duration-300 ease-in-out">Eliminar</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                            ¡No existen categorías almacenadas!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Paginación --}}
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
