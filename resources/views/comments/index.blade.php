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
                    <h1>Comentario Ticket</h1>

                    @can('comments.store')
                        <form action="{{ route('comments.store', $ticket) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas agregar un comentario al  ticket?')"
                        >
                            @csrf
                            @method('post')

                            <textarea name="content" placeholder="Escribe tu comentario aquí..."
                                class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="4" required></textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />

                            <div class="flex items-center justify-start mt-4">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Comentar
                                </button>
                                <a href="javascript:history.back()"
                                    class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Volver
                                </a>
                            </div>

                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
