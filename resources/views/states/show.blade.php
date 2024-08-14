<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <p class="text-2xl">Nombre : {{ $state->name }}</p>
                <p class="text-2xl">Estado : {{ $state->is_active ? 'On' :'Off' }}</p>
                <p class="text-2xl">Creado : {{ $state->created_at }}</p>
                
            </div>
            @can('states.edit')
            <a href="{{ route('states.edit',$state) }}">editar</a>
            @endcan
            @can('states.destroy')
            <form action="{{ route('states.destroy',$state) }}" method="POST">
                @csrf
                @method('delete')

                <button type="sutmit"> Eliminar</button>

            </form>
            @endcan
        </div>
    </div>
</x-app-layout>
