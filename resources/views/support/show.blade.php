<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1>Detalles del Ticket</h1>
                    <p><strong>ID del Ticket:</strong> {{ $ticket->id }}</p>
                    <p><strong>Título:</strong> {{ $ticket->title }}</p>

                    <h3>Asignado Actualmente a:</h3>
                    <p>
                        @if($assignments)
                        {{ $assignments->name }}
                        @else
                        No asignado
                        @endif
                    </p>

                    <h3>Historial de Asignaciones</h3>
                    
<ul>
    @foreach($ticket->assignedUsers as $assignment)
        <li>
            {{ $assignment->name }} asignado el {{ $assignment->pivot->created_at }}: {{ $assignment->pivot->details }}
            @if($assignment->pivot->is_active)
                <strong>(Asignación Actual)</strong>
            @endif
        </li>
    @endforeach
</ul>
                @can('support.store')
        
    
                    <h3>Asignar/Reasignar Ticket</h3>
                    <form action="{{ route('support.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Asignar a:</label>
                            <select name="user_id" id="user_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"">
                    @foreach($users as $user)
                                <option 
                                     value=" {{ $user->id }}">{{ $user->name }}
                                </option>
                    @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
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