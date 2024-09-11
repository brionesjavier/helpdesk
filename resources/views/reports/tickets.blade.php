<x-app-layout>
    <x-slot name="header">
        @if(session()->has('message'))
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
                <form method="GET" action="{{ route('reports.tickets') }}">
                    <div class="flex space-x-4 mb-4">
                        <input type="text" name="search" placeholder="Search by title, user, or ID" 
                               value="{{ $search }}" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">

                        <select name="priority" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">All Priorities</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>

                        <select name="status" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">All Statuses</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ request('status') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="start_date" placeholder="Start Date" 
                                class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">

                        <input type="date" name="end_date" placeholder="End Date" 
                               value="{{ request('end_date', now()->toDateString()) }}" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">

                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Search</button>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned Users</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">date Assigned Users</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Elemento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">solved At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $ticket->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $ticket->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @forelse($ticket->assignedUsers->unique('id') as $user)
                                                {{ $user->first_name }} {{ $user->last_name }}@if(!$loop->last), @endif
                                            @empty
                                                Sin asignar
                                            @endforelse
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @foreach($ticket->assignedUsers as $index => $user)
                                                @if ($index === 0)
                                                    {{ $user->pivot->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            @endforeach
                                        @if($ticket->assignedUsers->isEmpty())
                                            Sin asignar
                                        @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->state->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->priority ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->element->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"> {{ $ticket->element->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $ticket->solved_at ? $ticket->solved_at->format('Y-m-d H:i:s') : 'N/A'}}</td>

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
