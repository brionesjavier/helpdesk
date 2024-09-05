<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detailed Tickets Report
        </h2>
        
    </x-slot>

        {{-- El contenido principal de la página --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                       
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Assigned Users</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->title }}</td>
                                        <td>
                                            @foreach($ticket->assignedUsers as $user)
                                                {{ $user->first_name }} {{ $user->last_name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $ticket->state->name }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                        <td>{{ $ticket->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>