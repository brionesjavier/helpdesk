<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('states.store')
                        
                    
                    <form method="POST" action="{{ route('states.store') }}">
                        @csrf
                        @method('post')

                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  placeholder="Ingresa Nombre de la categoría" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        <div class="mt-4 space-x-8">
                            <x-primary-button>Guardar</x-primary-button>
                            @can('elements.index')
                            <a href="{{route('elements.index')}}" class="dark:text-gray-100">Cancelar</a>  
                            @endcan
                            
                        </div>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

