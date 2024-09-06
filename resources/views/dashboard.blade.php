<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300  dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-write dark:text-gray-100">

                    @if (auth()->user()->getAllPermissions()->isNotEmpty())

                    <p class="text-xl">Proceso de mis requerimientos</p>
                    <div class="flex flex-wrap gap-4 p-4">
                        
                        <!-- Tickets Pendientes -->
                        <div class="w-1/2 bg-red-600 text-white p-6 rounded-lg shadow-lg hover:bg-red-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            <p class="text-xl font-semibold">Tickets Pendientes</p>
                            <p class="text-4xl mt-2">{{ $ticketsPendientes }}</p>
                        </div>
                    
                        <!-- Tickets En Proceso -->
                        <div class="w-1/2 bg-blue-600 text-white p-6 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            <p class="text-xl font-semibold">Tickets En Proceso</p>
                            <p class="text-4xl mt-2">{{ $ticketsEnProceso }}</p>
                        </div>
                    
                        <!-- Tickets Solucionados -->
                        <div class="w-1/2 bg-green-600 text-white p-6 rounded-lg shadow-lg hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            <p class="text-xl font-semibold">Tickets Solucionados</p>
                            <p class="text-4xl mt-2">{{ $ticketsSolucionados }}</p>
                        </div>
                    
                        <!-- Tickets Cancelados -->
                        <div class="w-1/2 bg-yellow-600 text-white p-6 rounded-lg shadow-lg hover:bg-yellow-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                            <p class="text-xl font-semibold">Tickets Cancelados</p>
                            <p class="text-4xl mt-2">{{ $ticketsCancelados }}</p>
                        </div>
                    </div>
                    
                        
                           {{--  <p>El usuario tiene al menos uno de los permisos especificados.</p> --}}
                            {{-- <table class="table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Columna 1
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Columna 2
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Columna 3
                                        </th>
                                        <!-- Agrega más columnas si es necesario -->
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Datos 1
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            Datos 2
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            Datos 3
                                        </td>
                                       
                                        
                                        <!-- Agrega más celdas si es necesario -->
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Datos 1
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            Datos 2
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            Datos 3
                                        </td>
                                        <td> <button class="ring-2 ring-purple-500 ring-offset-4 ring-offset-slate-50 dark:ring-offset-slate-900 ...">
                                            Save Changes
                                          </button></td>
                                        
                                        <!-- Agrega más celdas si es necesario -->
                                    </tr>
                                    <!-- Agrega más filas si es necesario -->
                                </tbody>
                            </table>

                     --}}
                    @else
                        <p>El usuario no tiene permisos asignados.</p>
                    @endif

                    
              
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
