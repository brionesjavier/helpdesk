

<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
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
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="{{ route('tickets.edit',$ticket) }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Editar') }}</a>
                    
                </div>
            </div>
            @endcan
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                            <p>ticket : {{ $ticket->id }}</p> 
                            <p>Titulo: {{ $ticket->title }}</p> 
                            <p>creado por: {{ $ticket->user->name}}</p>
                            <p>proceso: {{ $ticket->state->name }}</p> 
                            @if ($ticket->solved_at)
                            <p>Fecha de Solución: {{ $ticket->solved_at }}</p>
                            @endif
                           
                            <p>Descripcion:</p>
                            
                            <p class="whitespace-pre-line">- {{ $ticket->description }}</p>

                </div>
                <div class="flex items-center p-4 text-gray-900 dark:text-gray-100s space-x-8">

                    @if ($ticket->state->id ==4)
                        @can('tickets.close')
                        <form action="{{ route('tickets.close',$ticket)}}" method="POST">
                            @csrf
                            @method('post')
                            <button type="submit" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">cerrar</button>
                        </form>
                        @endcan
                    @endif
                
                    <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                        @if ($ticket->state->id ==1 ||$ticket->state->id ==2 || $ticket->state->id ==3|| $ticket->state->id ==5)
                            @can('comments.index')
                                <a href="{{ route('comments.index',$ticket) }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Comentar') }}</a>
                            @endcan
                        @endif
                        @if ($ticket->state->id ==2 || $ticket->state->id ==3)
                            @can('tickets.derive')
                                <a href="{{ route('tickets.derive',$ticket )}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Derivar') }}</a>
                            @endcan
                        @endif

                        @if ($ticket->state->id ==2|| $ticket->state->id ==3||$ticket->state->id ==5)
                            @can('tickets.solve')
                                <a href="{{ route('tickets.solve',$ticket )}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('solucionar') }}</a>
                            @endcan
                        @endif
                        @if ($ticket->state->id != 4 && $ticket->state->id != 7 && $ticket->state->id != 8)
                            @can('tickets.cancel')
                            <a href="{{ route('tickets.cancel',$ticket )}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Cancelar/anular') }}</a>
                            @endcan
                        @endif

                        @if ($ticket->state->id == 4)
                            @can('tickets.reopen')
                                <a href="{{ route('tickets.reopen',$ticket )}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Objetar') }}</a>
                            @endcan
                        @endif
                    </div>
                

                
            </div>
                

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <ul>
                        @foreach($comments as $comment)
                            <li> {{ $comment->created_at }} {{ $comment->user->name }} </li>
                            <li>{{ $comment->content }}</li>
                        @endforeach
                    </ul>
                    
            
                    

                </div>
               {{--  <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                        @can('comments.index')
                        <a href="{{ route('comments.index',$ticket) }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Comentar') }}</a>
                        @endcan

                        @can('tickets.solve')
                        <a href="{{ route('tickets.solve',$ticket )}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('solucionar') }}</a>
                        @endcan
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>