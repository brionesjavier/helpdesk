<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p>{{ $ticket->title }}</p>
                <p>{{ $ticket->description }}</p>
                <p> {{ $ticket->user->name}}</p>
                <p> {{ $ticket->state->name }}</p>
            </div>
            <a href="{{ route('states.edit',$state) }}">editar</a>

        </div>
    </div>
</x-app-layout>