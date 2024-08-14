<x-app-layout>
    <x-slot name="header">
                  {{-- mensaje de evento --}}
                @if(session()->has('message'))
                  <div class="text-center bg-gray-100 rounded-md p-2">
                      <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
                  </div>
                @endif
                  @can('categories.create')

              <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                  <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
                      <a href="{{ route('categories.create') }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>
                      
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
                          <th class="border border-gray-400 px-4 py-2 text-gray-200">Categoría</th>
                          <th class="border border-gray-400 px-4 py-2 text-gray-200">Descripción</th>
                          <th class="border border-gray-400 px-4 py-2 text-gray-200">Año</th>
                          <th class="border border-gray-400 px-4 py-2 text-gray-200">Opcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $categories as $category )
                                <tr>
                                    <td class="border border-gray-400 px-4 py-2">{{ $category->name }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $category->description }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        @can('categories.show')
                                        <a href="{{ route('categories.show', $category) }}">ver</a>
                                        @endcan
                                        @can('categories.edit')
                                        <a href="{{ route('categories.edit', $category) }}">editar</a> 
                                        @endcan
                                        @can('categories.destroy')
                                            
                                        
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">eliminar</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            
                        @empty
                        <h2 class="text-xl text-white p-4">¡No existen categorías almacenadas!</h2>
                        @endforelse
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

