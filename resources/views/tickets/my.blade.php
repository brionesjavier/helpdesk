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
                My Tickets
            </h2>
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="{{ route('tickets.create') }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>
                    
                </div>
            </div>
            
        </div>

    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Fecha de creacion</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Folio</th> 
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Título</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Categoría y Elemento</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Estado actual</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Última actualizacion</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $tickets as $ticket )
                            <tr>
                                <td class="border border-gray-400 px-4 py-2">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $ticket->id}}</td>
                                    <td class="border border-gray-400 px-4 py-2"><a href="{{ route('tickets.show',$ticket) }}">{{ $ticket->title }}</a></td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $ticket->element->category->name }}/{{ $ticket->element->name}}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $ticket->state->name}}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $ticket->updated_at}}</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        @can('tickets.edit')
                                            <a href="{{route('tickets.edit',$ticket)}}" class="text-blue-500 hover:text-blue-700">editar</a>
                                        @endcan
                                        @can('tickets.show')
                                            <a href="{{route('tickets.show',$ticket)}}" class="text-blue-500 hover:text-blue-700">ver</a>
                                        @endcan
                                        @can('tickets.destroy')
                                        @if ($ticket->state_id== 8 ||$ticket->state_id== 7 )
                                        <form action="{{route('tickets.destroy',$ticket)}}" method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">delete</button>
                                        </form> 
                                        @endif
                                            
                                        @endcan
                                    </td>
                            </tr>

                            @empty
                            <h2 class="text-xl text-white p-4">¡No existen tickets almacenados!</h2>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- paginacion --}}
                    <div class="mt-4">
                        {{ $tickets->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


