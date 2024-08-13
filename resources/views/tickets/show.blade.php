

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
                    
                            <p>ticket : {{ $ticket->id }}</p> 
                            <p>Titulo: {{ $ticket->title }}</p> 
                            <p>creado por: {{ $ticket->user->name}}</p>
                            <p>proceso: {{ $ticket->state->name }}</p> 
                            @if ($ticket->solved_at)
                            <p>Fecha de Solución: {{ $ticket->solved_at }}</p>
                            @endif
                           
                            <p>Descripcion:</p>
                            <p> {{ $ticket->description }}</p>

                </div>
                <div class="p-6 text-gray-600 dark:text-gray-300">
                <a  href="{{ route('tickets.edit',$ticket) }}">editar</a>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <ul>
                        @foreach($comments as $comment)
                            <li>{{ $comment->user->name }} - {{ $comment->created_at }}</li>
                            <li>{{ $comment->content }}</li>
                        @endforeach
                    </ul>
                    
                    <a href="{{ route('comments.index',$ticket) }}">comentar</a>

                    <a href="{{ route('tickets.solve',$ticket )}}">solucionar</a>
                    
                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>