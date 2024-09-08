<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-900 rounded-md p-4 shadow-md mb-4">
                <span class="text-indigo-600 dark:text-indigo-400 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Histories
        </h2>
    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Fecha de Creación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Folio
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Categoría y Elemento
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Estado Actual
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Última Actualización
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tickets as $index => $ticket)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700' : 'bg-gray-100 dark:bg-gray-800' }} hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $ticket->id }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $ticket->element->category->name }}/{{ $ticket->element->name }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $ticket->state->name }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">{{ $ticket->updated_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700 flex space-x-2">
                                        @can('tickets.show')
                                            <a href="{{ route('tickets.show', $ticket) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded transition-colors duration-300">Ver</a>
                                        @endcan
                                        @can('history.index')
                                            <a href="{{ route('history.index', $ticket) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded transition-colors duration-300">Historial</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                        ¡No existen tickets almacenados!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
