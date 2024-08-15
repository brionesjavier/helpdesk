
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket') }}: {{ $ticket->id }} - {{ $ticket->state->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('tickets.solve.submit')
                    <h1>Derivar Ticket</h1>
                    <form action="{{ route('tickets.derive.submit', $ticket) }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="user_id">Derivar a:</label>
                            <select name="user_id" id="user_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"">
                    @foreach($users as $user)
                                <option 
                                     value=" {{ $user->id }}">{{ $user->name }}
                                </option>
                    @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>


                        <textarea 
                        name="content"
                        placeholder="Derivar requerimiento y detallar proceso"
                        class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required>
                        </textarea>
                        <button type="submit">Derivar</button>
                        <button onclick="window.history.back();">Volver</button>
                    </form>
                    @endcan
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>