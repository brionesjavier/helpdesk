<x-app-layout>

    <x-slot name="header">
        {{-- mensaje de evento --}}
      @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
      @endif


    <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
            <a href="{{ route('elements.create') }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>
            
        </div>
    </div>
</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
               
                
                @forelse ( $elements as $element )
                <p>nombre :{{ $element->name }}</p>
                <p>descripcion :{{ $element->description }}</p>
                <p>categoria id {{ $element->category_id }}</p>
                <p>creado: {{ $element->created_at }}</p>
                   <br>
                @empty
                <p>No hay elementos</p>
                    
                @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
