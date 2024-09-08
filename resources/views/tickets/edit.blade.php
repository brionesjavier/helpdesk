<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('tickets.update')
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del requerimiento</label>
                                <x-text-input 
                                    id="title" 
                                    class="mt-1 block w-full" 
                                    type="text" 
                                    name="title" 
                                    value="{{ $ticket->title }}"  
                                    placeholder="Ingresa el título del requerimiento" 
                                />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                                <select 
                                    name="category" 
                                    onchange="loadElement(this)" 
                                    id="category" 
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                >
                                    <option value="{{ $ticket->element->category->id }}" selected>{{ $ticket->element->category->name }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <div>
                                <label for="element_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Elementos</label>
                                <select 
                                    id="element_id" 
                                    name="element_id" 
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                >
                                    <!-- Opciones de elementos se llenarán dinámicamente -->
                                    <option value="{{ $ticket->element_id }}">{{ $ticket->element->name }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('element_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                                <textarea 
                                    name="description" 
                                    placeholder="Escribe el problema aquí..." 
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 rounded-md shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                >{{ $ticket->description }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="flex gap-4 mt-6">
                                <x-primary-button>Guardar</x-primary-button>
                                @can('tickets.my')
                                    <a href="{{ route('tickets.my') }}" class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">Cancelar</a>
                                @endcan
                            </div>
                        </form>
                        <script src="{{ asset('js/categorias.js') }}" defer></script>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
