<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1>Detalles del Ticket</h1>

                    <p>ticket : {{ $ticket->id }}</p> 
                    <p>Titulo: {{ $ticket->title }}</p> 
                    <p>creado por: {{ $ticket->user->first_name}}{{ $ticket->user->last_name}}</p>
                    <p>proceso: {{ $ticket->state->name }}</p> 

                   <div class=" border rounded-lg  bg-gray-600">
                        <p>Descripcion:</p>
                        
                        <p class="whitespace-pre-line">- {{ $ticket->description }}</p>
                    </div>
                    <h3>Asignado Actualmente a:</h3>
                    <p>
                        @if($assignments)
                        {{ $assignments->first_name }} {{ $assignments->last_name }}
                        @else
                        No asignado
                        @endif
                    </p>
                    @if ($assignments)
                   
                    @endif
                @can('support.store')
        
                <div class="border-y-2 border-gray-300 my-4">
                    <h3>Historial de Asignaciones</h3>
                    
                    <ul>
                        @foreach($ticket->assignedUsers as $assignment)
                            <li>
                                {{ $assignment->first_name }} {{ $assignment->last_name }} asignado el {{ $assignment->pivot->created_at }}: {{ $assignment->pivot->details }}
                                @if($assignment->pivot->is_active)
                                    <strong>(Asignación Actual)</strong>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                    {{-- <h3>Asignar/Reasignar Ticket</h3> --}}
                    <form action="{{ route('support.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Asignar a:</label>
                            <select name="user_id" id="user_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                
                            @forelse ( $users as $user )
                                <option 
                                value=" {{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @empty
                                <option value="">Sin usuarios</option>
                            @endforelse
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                               

                            <label for="user_id">Prioridad</label>
                            <select name="priority" id="priority" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>
                        <div class="form-group ">
                            <label for="details">Detalles:</label>
                            <textarea class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="details" id="details" rows="3"></textarea>
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>
                        <button type="submit" class="btn btn-primary">Asignar/Reasignar</button>
                    </form>
                @endcan
                </div>



            </div>
        </div>
    </div>
</x-app-layout>