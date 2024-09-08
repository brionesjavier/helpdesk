<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ticket') }}: {{ $ticket->id }} - {{ $ticket->state->name }}
            </h2>
            @can('tickets.edit')
            {{-- <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100 space-x-4"> --}}
                    <a href="{{ route('tickets.edit',$ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Editar') }}</a>
            {{--     </div>
            </div> --}}
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-2"><strong>Ticket:</strong> {{ $ticket->id }}</p>
                    <p class="mb-2"><strong>Título:</strong> {{ $ticket->title }}</p>
                    <p class="mb-2"><strong>Creado por:</strong> {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</p>
                    <p class="mb-2"><strong>Proceso:</strong> {{ $ticket->state->name }}</p>
                    @if ($ticket->solved_at)
                    <p class="mb-2"><strong>Fecha de Solución:</strong> {{ $ticket->solved_at->format('d/m/Y H:i') }}</p>
                    @endif
                    <p class="mb-2"><strong>Descripción:</strong></p>
                    <p class="whitespace-pre-line">{{ $ticket->description }}</p>
                </div>

                @if ($ticket->is_active)
                <div class="flex flex-wrap items-center p-4 space-x-4">
                    @if ($ticket->state->id == 4)
                    @can('tickets.close')
                    <form action="{{ route('tickets.close', $ticket) }}" method="POST">
                        @csrf
                        @method('post')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">{{ __('Cerrar') }}</button>
                    </form>
                    @endcan
                    @endif

                    @if ($ticket->state->id == 2 || $ticket->state->id == 5)
                    @can('tickets.process')
                    <a href="{{ route('tickets.process', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">{{ __('Comenzar Proceso') }}</a>
                    @endcan
                    @endif

                    @if ($ticket->state->id == 1 || $ticket->state->id == 2 || $ticket->state->id == 3 || $ticket->state->id == 5)
                    @can('comments.index')
                    <a href="{{ route('comments.index', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Comentar') }}</a>
                    @endcan
                    @endif

                    @if ($ticket->state->id == 2 || $ticket->state->id == 3)
                    @can('tickets.derive')
                    <a href="{{ route('tickets.derive', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">{{ __('Derivar') }}</a>
                    @endcan
                    @endif

                    @if ($ticket->state->id == 2 || $ticket->state->id == 3 || $ticket->state->id == 5)
                    @can('tickets.solve')
                    <a href="{{ route('tickets.solve', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">{{ __('Solucionar') }}</a>
                    @endcan
                    @endif

                    @if ($ticket->state->id != 4 && $ticket->state->id != 7 && $ticket->state->id != 8)
                    @can('tickets.cancel')
                    <a href="{{ route('tickets.cancel', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">{{ __('Cancelar/Anular') }}</a>
                    @endcan
                    @endif

                    @if ($ticket->state->id == 4)
                    @can('tickets.reopen')
                    <a href="{{ route('tickets.reopen', $ticket) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">{{ __('Reabrir') }}</a>
                    @endcan
                    @endif
                </div>
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-lg">
                        @foreach($comments as $comment)
                        <div class="mb-4 border border-gray-300 dark:border-gray-700 rounded-lg">
                            <!-- Barra superior: Fecha, nombre y estado -->
                            <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 p-2 rounded-t-lg">
                                <span>{{ $comment->created_at->format('d/m/Y H:i') }} - </span>
                                <span>{{ $comment->user->first_name }} {{ $comment->user->last_name }} - </span>
                                <span>Proceso: {{ $comment->state_ticket }}</span>
                            </div>
                            <!-- Barra inferior: Contenido del comentario -->
                            <div class="bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 p-4 rounded-b-lg">
                                {{ $comment->content }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
