<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Crear Tickets 
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('tickets.store')
                    <form method="POST" action="{{route('tickets.store')}}" onsubmit="return confirm('¿Estás seguro de que deseas crear el ticket?');">
                        @csrf
                        @method('post')
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titulo del requerimiento</label>
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"  placeholder="Ingresa Nombre de la categoría" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />

                           
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                        <select name="category"  id="" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="" selected>Seleccione una categoría</option>
                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}" >{{  $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />

                        <label for="element_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Elementos</label>
                        <select id="element_id" name="element_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <!-- Opciones de elementos se llenarán dinámicamente -->
                            <option value="">Selecciona un elemento</option>
                        </select>
                        <x-input-error :messages="$errors->get('element_id')" class="mt-2" />

                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripcion</label>
                            <textarea
                            name="description"
                            placeholder="Escribe el problema  aquí..."
                            class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />

                        <div class="mt-4 space-x-8">
                            <x-primary-button>Guardar</x-primary-button>
                            @can('tickets.my')
                            <a href="{{route('tickets.my')}}" class="dark:text-gray-100">Cancelar</a> 
                            @endcan
                            
                        </div>
                    </form>
                    
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>