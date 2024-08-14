
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
                    <h1>Solucionar Ticket</h1>
                    <form action="{{ route('tickets.solve.submit', $ticket) }}" method="POST">
                        @csrf
                        @method('post')
                        <textarea 
                        name="content"
                        placeholder="Solucionar requerimiento y detallar proceso"
                        class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required>
                        </textarea>
                        <button type="submit">Solucionar</button>
                        <button onclick="window.history.back();">Volver</button>
                    </form>
                    @endcan
                    @cannot('tickets.solve.submit')
                        <h2>
                            No cuenta con permisos
                        </h2>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</x-app-layout>