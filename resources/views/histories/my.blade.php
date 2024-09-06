<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Histories
        </h2>
        
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
                                                                                @can('tickets.show')
                                                                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500 hover:text-blue-700">ver</a>
                                                                                @endcan
                                                                                @can('history.index')
                                                                                    <a href="{{ route('history.index',$ticket) }}">Historial</a>
                                                                                 @endcan
                                    </td>
                            
                                </tr>
    
                                @empty
                                <h2 class="text-xl text-white p-4">¡No existen tickets almacenados!</h2>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $tickets->links() }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>