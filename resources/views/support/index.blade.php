<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if (session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-700 rounded-md p-2">
                <span class="text-indigo-600 dark:text-indigo-300 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        @can('tickets.create')
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Listado de Tickets
                </h2>
            </div>
        @endcan
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('support.search')


                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('support.index') }}"
                            class="mb-6 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                            <div class="flex flex-col space-y-4">
                                <div class="flex flex-col md:flex-row md:space-x-4">

                                    <!-- Título o Folio -->
                                    <div class="flex-1">
                                        <x-input-label for="search" :value="__('Buscar por título o folio')" />
                                        <x-text-input id="search" class="block mt-1 w-full" type="text" name="search"
                                            value="{{ request('search') }}" />
                                    </div>

                                    <!-- Usuario -->
                                    <div class="flex-1">
                                        <x-input-label for="user" :value="__('Usuario')" />
                                        <select id="user" name="user"
                                            class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                            <option value="all" {{ request('user') == 'all' ? 'selected' : '' }}>Todos
                                            </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request('user') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Otros filtros y botones -->
                                <div class="flex flex-col md:flex-row md:items-end md:space-x-4 mt-4">

                                    <!-- Estado -->
                                    <div class="flex-1">
                                        <x-input-label for="state" :value="__('Estado')" />
                                        <select id="state" name="state"
                                            class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                            <option value="all" {{ request('state') == 'all' ? 'selected' : '' }}>Todos
                                                los estados</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ request('state') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Asignación -->
                                    <div class="flex-1">
                                        <x-input-label for="assignment" :value="__('Asignación')" />
                                        <select id="assignment" name="assignment"
                                            class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                            <option value="all" {{ request('assignment') == 'all' ? 'selected' : '' }}>
                                                Todos</option>
                                            <option value="has_assignment"
                                                {{ request('assignment') == 'has_assignment' ? 'selected' : '' }}>Con
                                                asignación</option>
                                            <option value="no_assignment"
                                                {{ request('assignment') == 'no_assignment' ? 'selected' : '' }}>Sin
                                                asignación</option>
                                        </select>
                                    </div>

                                    <!-- Ordenar Por -->
                                    <div class="flex-1">
                                        <x-input-label for="sort_by" :value="__('Ordenar por')" />
                                        <select id="sort_by" name="sort_by"
                                            class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                            <option value="created_at"
                                                {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Fecha de
                                                creación</option>
                                            <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Folio
                                            </option>
                                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>
                                                Título</option>
                                            <option value="updated_at"
                                                {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Última
                                                actualización</option>
                                        </select>
                                    </div>

                                    <!-- Ordenar Dirección -->
                                    <div class="flex-1">
                                        <x-input-label for="sort_direction" :value="__('Dirección')" />
                                        <select id="sort_direction" name="sort_direction"
                                            class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50">
                                            <option value="desc"
                                                {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descendente
                                                <span class="inline-block ml-2">&#9660;</span>
                                            </option>
                                            <option value="asc"
                                                {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascendente
                                                <span class="inline-block ml-2">&#9650;</span>
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botones de Buscar y Limpiar -->
                                <div class="flex space-x-2 mt-4">
                                    <x-primary-button class="w-full md:w-auto">
                                        {{ __('Buscar') }}
                                    </x-primary-button>
                                    <a href="{{ route('support.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition duration-300 ease-in-out">
                                        {{ __('Limpiar') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    @endcan
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Título</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Categoría y Elemento</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Estado</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Usuario</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Creado</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Asignación</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($tickets as $index => $ticket)
                                    <tr
                                        class="{{ $index % 2 == 0 ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-50 dark:bg-gray-800' }} hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ route('tickets.show', $ticket) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ $ticket->id }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 truncate"
                                            title="{{ $ticket->title }}" style="max-width: 300px;">
                                            <a href="{{ route('tickets.show', $ticket) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ $ticket->title }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 truncate"
                                            style="max-width: 200px;"
                                            title="{{ $ticket->element->category->name }} - {{ $ticket->element->name }}">
                                            {{ $ticket->element->category->name }} - {{ $ticket->element->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->state->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @forelse ($ticket->assignedUsers as $assignment)
                                                @if ($assignment->pivot->is_active)
                                                    <span class="text-green-500">Activo</span>
                                                @endif
                                            @empty
                                                <span class="text-red-500">Inactivo</span>
                                            @endforelse
                                        </td>
                                        @can('support.store')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('support.show', $ticket) }}"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">
                                                    Asignar
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            ¡No existen tickets almacenados!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ __('$tickets->links()') }}
                            {{ $tickets->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
