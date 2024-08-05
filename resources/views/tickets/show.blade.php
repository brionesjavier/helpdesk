

<x-app-layout>

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
            </div>
        </div>
    </div>
</x-app-layout>