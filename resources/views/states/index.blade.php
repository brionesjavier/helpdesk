<x-app-layout>

    <x-slot name="header">
        {{-- mensaje de evento --}}
      @if(session()->has('message'))
        <div class="text-center bg-gray-100 rounded-md p-2">
            <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
        </div>
      @endif

@can('states.create')
    

    <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
            <a href="{{ route('states.create') }}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>
            
        </div>
    </div>
    @endcan
</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
               
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse ( $states as $state )
                    <p>nombre :{{ $state->name }}</p>
                    <p>Estado: {{ $state->is_active ? 'On' :'Off' }}</p>
                    @can('states.show')
                    <a href="{{ route('states.show',$state) }}">link</a>
                    @endcan
                    <br>
                    @empty
                    <p>No hay elementos</p>
                        
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
