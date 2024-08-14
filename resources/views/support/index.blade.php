<x-app-layout>
    <x-slot name="header">
        {{-- mensaje de evento --}}
        @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
        @endif

        @can('tickets.create')
            
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
                <a href="{{ route('tickets.create') }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>

            </div>
        </div>
        @endcan
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
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">estado</th>
                                <th class="border border-gray-400 px-4 py-2 text-gray-200">asignar</th>
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
                                    
                                    @forelse ( $ticket->assignedUsers as $assignment )
                                            @if($assignment->pivot->is_active)
                                                <span class="text-green-500">Activo</span>  
                                            @endif
                                    @empty
                                        <span class="text-red-500">Inactivo</span>
                                    @endforelse
                                       
                                </td>


                                @can('support.show')
                                <td class="border border-gray-400 px-4 py-2">
                                    <a href="{{route('support.show',$ticket)}}">ver</a>
                                </td>
                                @endcan
                            </tr>

                            @empty
                            <h2 class="text-xl text-white p-4">¡No existen ticket almacenados!</h2>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>