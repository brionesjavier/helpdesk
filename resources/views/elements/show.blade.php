<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
           
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <p>categoria : {{ $element->category->name }}</p>
                <p>Elemento :{{ $element->name }}</p>
                <p>descripcion :{{ $element->description }}</p>
                {{-- <p>categoria id {{ $element->category_id }}</p> --}}

                <p>creado: {{ $element->created_at }}</p>
                <p>Estado: {{ $element->is_active ? 'On' :'Off' }}</p>

                <a href="{{ route('elements.edit',$element) }}">editar</a>

                <form action="{{ route('elements.destroy',$element) }}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white">Eliminar</button>
                </form>
                

                <br>

            </div>
        </div>
    </div>
</div>
</x-app-layout>
