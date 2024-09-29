
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket') }}: {{ $ticket->id }} - {{ $ticket->state->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @can('tickets.solve.submit')
                   
                    <h1>Solucionar Ticket</h1>
                    <form action="{{ route('tickets.solve.submit', $ticket) }}" method="POST">
                        @csrf
                        @method('post')

                        <div>
                            <label for="category"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                            <select name="category" id="category"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="{{ $ticket->element->category->id }}" selected>
                                    {{ $ticket->element->category->name }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
    
                        <div>
                            <label for="element_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Elementos</label>
                            <select id="element_id" name="element_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <!-- Opciones de elementos se llenarán dinámicamente -->
                                <option value="{{ $ticket->element_id }}">{{ $ticket->element->name }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('element_id')" class="mt-2" />
                        </div>
                        <textarea 
                        name="content"
                        placeholder="Solucionar requerimiento y detallar proceso"
                        class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 placeholder-gray-400 dark:placeholder-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required>
                        </textarea>
                        
                        <div class="flex items-center justify-start mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Solucionar
                            </button>
                            <a href="javascript:history.back()" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Volver
                            </a>
                        </div>
                    </form>
                    @endcan
                    @cannot('tickets.solve.submit')
                        <h2>
                            No cuenta con permisos
                        </h2>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</x-app-layout>