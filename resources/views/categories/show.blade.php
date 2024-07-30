<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <p class="text-2xl">Nombre : {{ $category->name }}</p>
                <p  class="text-2xl">descripcion : {{ $category->description }}</p>
                <p  class="text-2xl">Creado : {{ $category->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

