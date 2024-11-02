<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if (session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-700 rounded-md p-2">
                <span class="text-indigo-600 dark:text-indigo-300 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Ticket') }} {{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
{{-- 
                    <h1 class="text-2xl font-semibold mb-4">Detalles del Ticket {{ $ticket->id }} </h1>
 --}}
                    <div class="mb-4">
                        <p><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
                        <p><strong>Título:</strong> {{ $ticket->title }}</p>
                        <p><strong>Creado por:</strong> {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</p>
                        <p><strong>Proceso:</strong> {{ $ticket->state->name }}</p>
                    </div>

                    <div class="border rounded-lg bg-gray-100 dark:bg-gray-700 p-4 mb-4">
                        <p class="font-semibold mb-2">Descripción:</p>
                        <p class="whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">Asignado Actualmente a:</h3>
                        <p>
                            @if($assignments)
                                {{ $assignments->first_name }} {{ $assignments->last_name }}
                            @else
                                No asignado
                            @endif
                        </p>
                    </div>

                    @can('support.store')
                        <div class="border-t border-gray-300 dark:border-gray-600 my-4 pt-4">
                            <h3 class="text-lg font-semibold mb-4">Historial de Asignaciones</h3>
                            <ul class="list-disc pl-5 mb-4">
                                @foreach($ticket->assignedUsers as $assignment)
                                    <li>
                                        {{ $assignment->first_name }} {{ $assignment->last_name }} asignado el {{ $assignment->pivot->created_at }}: {{ $assignment->pivot->details }}
                                        @if($assignment->pivot->is_active)
                                            <strong class="text-green-600 dark:text-green-400">(Asignación Actual)</strong>
                                        @else
                                            <strong class="text-red-600 dark:text-red-400">(Sin Asignación )</strong>

                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                
                             @if ((!in_array($ticket->state_id, [4,7,8])&& $ticket->is_active == 1))
    

                            <h3 class="text-lg font-semibold mb-2">Asignar/Reasignar Ticket</h3>
                            <form action="{{ route('support.store', $ticket) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas asignar el ticket?');">
                                @csrf
                                <div class="mb-4">
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asignar a:</label>
                                    <select name="user_id" id="user_id" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        @forelse($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @empty
                                            <option value="">Sin usuarios</option>
                                        @endforelse
                                    </select>
                                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prioridad:</label>
                                    <select name="priority" id="priority" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <label for="details" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detalles:</label>
                                    <textarea name="details" id="details" rows="3" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                    <x-input-error :messages="$errors->get('details')" class="mt-2" />
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 ease-in-out">
                                    Asignar/Reasignar
                                </button>
                                <a href="javascript:history.back()" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Volver
                                </a>
                            </form>
                            @else
                            <p class="text-red-500">No se puede asignar o reasignar el ticket en el estado actual.</p>
                            
                            @endif
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
