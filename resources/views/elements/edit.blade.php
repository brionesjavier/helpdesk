
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('elements.update')
                        
                    
                    <form method="POST" action="{{ route('elements.update',$element) }}">
                        @csrf
                        @method('put')

                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Categoría</label>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $element->name }}"  placeholder="Ingresa Nombre de la categoría" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                            <select name="category_id" id="category_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
 

                                @foreach ($categories as $key => $category)
                                    @if ($category->id==$element->category->id)
                                        <option value="{{ $category->id }}" selected > {{  $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}" >{{  $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />

                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea
                            name="description"
                            placeholder="Escribe la descripción de la categoría aquí..."
                            class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >{{ $element->description }}</textarea>
                        
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />

                        <div class="mt-4 space-x-8">
                            <x-primary-button>actualizar</x-primary-button>
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

