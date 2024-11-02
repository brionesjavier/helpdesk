<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if (session()->has('message'))
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
                    @can('histories.my.search')


                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('histories.my') }}"
                            class="mb-6 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4">
                                <!-- Título o Folio -->
                                <div class="flex-1">
                                    <x-input-label for="search" :value="__('Buscar por título o folio')" />
                                    <x-text-input id="search" class="block mt-1 w-full" type="text" name="search"
                                        value="{{ request('search') }}" />
                                </div>

                                <!-- Estado -->
                                <div class="flex-none">
                                    <x-input-label for="state" :value="__('Estado')" />
                                    <select id="state" name="state"
                                        class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                        <option value="" {{ request('state') == 'all' ? 'selected' : '' }}>Todos los
                                            estados</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{ request('state') == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ordenar Por -->
                                <div class="flex-none">
                                    <x-input-label for="sort_by" :value="__('Ordenar por')" />
                                    <select id="sort_by" name="sort_by"
                                        class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                        <option value="created_at"
                                            {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Fecha de creación
                                        </option>
                                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Folio
                                        </option>
                                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Título
                                        </option>
                                        <option value="updated_at"
                                            {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Última actualización
                                        </option>
                                    </select>
                                </div>

                                <!-- Ordenar Dirección -->
                                <div class="flex-none relative">
                                    <x-input-label for="sort_direction" :value="__('Dirección')" />
                                    <select id="sort_direction" name="sort_direction"
                                        class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                        <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>
                                            Descendente
                                            <span class="inline-block ml-2">&#9660;</span> <!-- Flecha hacia abajo -->
                                        </option>
                                        <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>
                                            Ascendente
                                            <span class="inline-block ml-2">&#9650;</span> <!-- Flecha hacia arriba -->
                                        </option>
                                    </select>
                                </div>

                                <!-- Botones de Buscar y Limpiar -->
                                <div class="flex space-x-2">
                                    <x-primary-button class="w-full">
                                        {{ __('Buscar') }}
                                    </x-primary-button>
                                    <a href="{{ route('histories.my') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition duration-300 ease-in-out">
                                        {{ __('Limpiar') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    @endcan
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Fecha de Creación
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Folio
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Título
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Categoría y Elemento
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Estado Actual
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Última Actualización
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tickets as $index => $ticket)
                                <tr
                                    class="{{ $index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700' : 'bg-gray-100 dark:bg-gray-800' }} hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        {{ $ticket->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        {{ $ticket->id }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        <a href="{{ route('tickets.myshow', $ticket) }}"
                                            class="text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        {{ $ticket->element->category->name }}/{{ $ticket->element->name }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        {{ $ticket->state->name }}</td>
                                    <td class="px-6 py-3 text-sm border-b border-gray-300 dark:border-gray-700">
                                        {{ $ticket->updated_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-3 text-sm flex space-x-2 my-4">
                                        @can('tickets.myshow')
                                            <a href="{{ route('tickets.myshow', $ticket) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded transition-colors duration-300">Ver</a>
                                        @endcan
                                        @can('history.index')
                                            <a href="{{ route('history.index', $ticket) }}"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded transition-colors duration-300">Historial</a>
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
