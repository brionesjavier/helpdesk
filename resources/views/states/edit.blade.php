<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('states.update',$state) }}">
                        @csrf
                        @method('put')

                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $state->name }}"  placeholder="Ingresa Nombre de la categoría" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        <div class="mt-4 space-x-8">
                            <x-primary-button>actualizar</x-primary-button>
                            <a href="{{route('elements.index')}}" class="dark:text-gray-100">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>