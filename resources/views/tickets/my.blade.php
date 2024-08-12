<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Tickets
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">titulo</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">categoria</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">elemento</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">estado</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">usuario</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">creado</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $tickets as $ticket )
                            <tr>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->title }}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->element->category->name }}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->element->name}}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->state->name}}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->user->name}}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                <td class="border border-gray-400 px-4 py-2">
                                    <a href="{{route('tickets.edit',$ticket)}}">editar</a> 
                                    <a href="{{route('tickets.show',$ticket)}}">ver</a>
                                    <form action="{{route('tickets.destroy',$ticket)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white">delete</button>

                                    </form>
                            
                                </td>
                            </tr>

                            @empty
                            <h2 class="text-xl text-white p-4">¡No existen tickets almacenados!</h2>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>