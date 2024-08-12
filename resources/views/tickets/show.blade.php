

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
                    <form action="{{ route('comments.store', $ticket) }}" method="POST">
                        @csrf
                        <textarea 
                        class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        name="content" required></textarea>
                        <button type="submit">Comentar</button>
                    </form>
                    
                    

                </div>
            </div>
        </div>
    </div>
</x-app-layout>