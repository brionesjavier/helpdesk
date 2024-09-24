<x-app-layout>
    <x-slot name="header">
        @if (session()->has('message'))
            <div class="text-center bg-gray-100 rounded-md p-2 mb-4">
                <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tickets Report & Role Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Buscador y filtros -->
            <div class="mb-4">
                <form action="{{ route('reports.tickets') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 p-2 rounded-lg ">
                        <!-- Filtro de búsqueda -->
                        <div>
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Buscar</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Filtro de estado -->
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Estado</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="">Todos los estados</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ request('status') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de prioridad -->
                        <div>
                            <label for="priority"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Prioridad</label>
                            <select name="priority" id="priority"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="">Todas las prioridades</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta
                                </option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Media
                                </option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baja
                                </option>
                            </select>
                        </div>

                        <!-- Filtro de categoría -->
                        <div>
                            <label for="category"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Categoría</label>
                            <select name="category" id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="">Todas las Categorías</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de usuario asignado -->
                        <div>
                            <label for="user"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Usuario Asignado</label>
                            <select name="user" id="user"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="">Todos los usuarios</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro de fecha de inicio -->
                        <div>
                            <label for="start_date"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Fecha de Inicio</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Filtro de fecha de fin -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-white">Fecha
                                de Fin</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Filtro de ordenar por -->
                        <div>
                            <label for="order_by"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Ordenar por:</label>
                            <select name="order_by" id="order_by"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="created_at"
                                    {{ request('order_by') === 'created_at' ? 'selected' : '' }}>Fecha de creación
                                </option>
                                <option value="priority" {{ request('order_by') === 'priority' ? 'selected' : '' }}>
                                    Prioridad</option>
                                <option value="title" {{ request('order_by') === 'title' ? 'selected' : '' }}>Título
                                </option>
                                <option value="id" {{ request('order_by') === 'id' ? 'selected' : '' }}>Folio
                                </option>
                            </select>
                        </div>

                        <!-- Filtro de dirección -->
                        <div>
                            <label for="direction"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Dirección:</label>
                            <select name="direction" id="direction"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>
                                    Ascendente</option>
                                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>
                                    Descendente</option>
                            </select>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Aplicar Filtros
                            </button>
                            <a href="{{ route('reports.tickets') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Tabla de tickets -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Title</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Created At</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Assigned Users</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        date Assigned Users</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        SLA Atencion</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Priority</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Categoría</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Elemento</th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Description</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        solved At</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        SLA solucion At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($tickets as $ticket)
                                    <tr
                                        class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->id }}</a>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->title }}</a>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ route('support.show', $ticket) }}">
                                                @forelse($ticket->assignedUsers->unique('id') as $user)
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @empty
                                                    Sin asignar
                                                @endforelse
                                            </a>
                                        </td>

                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">

                                            @foreach ($ticket->assignedUsers as $index => $user)
                                                @if ($index === 0)
                                                    {{ $user->pivot->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            @endforeach

                                            @if ($ticket->assignedUsers->isEmpty())
                                                Sin asignar
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">



                                            @if ($ticket->assignedUsers->count() > 0)
                                                {{ $ticket->sla }} minutos
                                            @else
                                                {{ $ticket->getSlaInMinutesAttribute() }} minutos
                                            @endif

                                        </td>


                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->state->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->priority ?? 'N/A' }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->element->category->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->element->name }}</td>

                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->description }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->solved_at ? $ticket->solved_at->format('Y-m-d H:i:s') : 'N/A' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->getSlaSolutionInMinutesAttribute() ? $ticket->getSlaSolutionInMinutesAttribute() . ' minutos' : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $tickets->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
