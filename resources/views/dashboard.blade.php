<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <p class="text-red-600">general</p>
                    <p><a href="{{ route('tickets.my') }}">bandeja mis ticket </a></p>
                    <ul><li>*ver detalles ticket</li>
                        <li>*Editar Ticket</li>
                        <li>*Eliminar ticket</li>
                    </ul>

                    <p><a href="{{ route('tickets.create') }}">Crear ticket</a></p>

                    
                    <br>
                    <p class="text-red-600" >soporte y administradores</p>
                    <p><a href="{{ route('support.assigned') }}">bandeja ticket asignados</a></p>
                    <p><a href="{{ route('support.index') }}">bandeja asignar</a></p>
                    <p><a href="{{ route('tickets.index') }}">bandeja ticket </a></p>


                    <div class="list-disc">
                        <h1 class="text-2xl font-bold mb-4">Nota de permisos </h1>

                        <p class="text-2xl font-bold mb-4">Usuario Básico</p>
                        <ul class="list-disc">
                            <li class="text-lg text-gray-700 line-through">crear requerimientos</li>
                            <li class="text-lg text-gray-700 line-through">ver requerimientos propios</li>
                            <li class="text-lg text-gray-700 line-through">editar requerimientos propios</li>
                            <li class="text-lg text-gray-700 line-through" >eliminar requerimientos propios</li>
                            <li class="text-lg text-gray-700 line-through" >agregar comentarios a requerimientos</li>
                          </ul>

                      
                        <p class="text-2xl font-bold mb-4">Administrador de Cuenta</p>
                        <ul class="list-none hover:list-disc">
                            <li>ver usuarios</li>
                            <li>crear usuarios</li>
                            <li>editar usuarios</li>
                            <li>eliminar usuarios</li>
                            <li>asignar roles</li>
                        </ul>

                        
                        <p class="text-2xl font-bold mb-4">Agente de Soporte</p>
                      <ul>
                        <li class="text-lg text-gray-700 line-through">ver todos los requerimientos</li>
                        <li class="text-lg text-gray-700 line-through">editar  los requerimientos asignados</li>
                        <li>cambiar estado de requerimientos</li>
                        <li class="text-lg text-gray-700 line-through">agregar comentarios a requerimientos</li>
                        <li class="text-lg text-gray-700 line-through">asignar requerimientos</li>
                    </ul>
                    
                        
                            <p class="text-2xl font-bold mb-4">Administrador de Soporte</p>
                    <ul>
                            <li class="text-lg text-gray-700 line-through">ver todos los requerimientos</li>
                            <li>editar todos los requerimientos</li>
                            <li>eliminar todos los requerimientos</li>
                            <li class="text-lg text-gray-700 line-through" >asignar requerimientos</li>
                            <li class="text-lg text-gray-700 line-through">cambiar estado de requerimientos</li>
                            <li class="text-lg text-gray-700 line-through">agregar comentarios a requerimientos</li>
                            <li class="text-lg text-gray-700 line-through">ver historial de requerimientos</li>
                            <li class="text-lg text-gray-700 line-through">gestionar elementos</li>
                            <li class="text-lg text-gray-700 line-through">ver categorías</li>
                            <li class="text-lg text-gray-700 line-through">crear categorías</li>
                            <li class="text-lg text-gray-700 line-through">editar categorías</li>
                            <li class="text-lg text-gray-700 line-through">eliminar categorías</li>
                        </ul>
                           
                            <p class="text-2xl font-bold mb-4">Supervisor</p>
                        
                            <ul>
                                <li class="text-lg text-gray-700 line-through">ver todos los requerimientos</li> 
                                <li class="text-lg text-gray-700 line-through">ver historial de requerimientos</li> 
                                <li >cambiar estado de requerimientos</li>
                                <li>gestionar elementos</li>
                            </ul>
                        
                    
                        <p class="text-2xl font-bold mb-4">Administrador General</p>
                        <ul><li>Todo los permisos</li></ul>
                    
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
