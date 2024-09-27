<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (auth()->user()->getAllPermissions()->isNotEmpty())
                        <p class="text-xl font-semibold mb-4">Proceso de Mis Requerimientos</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                            <!-- Tickets Pendientes -->
                            <div class="bg-red-600 text-white p-6 rounded-lg shadow-lg hover:bg-red-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Pendientes</p>
                                <p class="text-4xl mt-2">{{ $ticketsPendientes }}</p>
                            </div>
                        
                            <!-- Tickets En Proceso -->
                            <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets En Proceso</p>
                                <p class="text-4xl mt-2">{{ $ticketsEnProceso }}</p>
                            </div>
                        
                            <!-- Tickets Solucionados -->
                            <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Solucionados</p>
                                <p class="text-4xl mt-2">{{ $ticketsSolucionados }}</p>
                            </div>
                        
                            <!-- Tickets Cancelados -->
                            <div class="bg-yellow-600 text-white p-6 rounded-lg shadow-lg hover:bg-yellow-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Cancelados</p>
                                <p class="text-4xl mt-2">{{ $ticketsCancelados }}</p>
                            </div>

                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos asignados.</p>
                    @endif

                </div>
            </div>
            
        </div>
        
    </div>

    <div >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (auth()->user()->getAllPermissions()->isNotEmpty())
                        <p class="text-xl font-semibold mb-4"> Requerimientos agente soporte</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                            <!-- Tickets Asignados / Derivado /objetado-->
                            <div class="bg-rose-600 text-white p-6 rounded-lg shadow-lg hover:bg-rose-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Tickets en Gestión</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestion }}</p>
                            </div>
                        
                            <!-- Tickets En Proceso -->
                            <div class="bg-teal-500 text-white p-6 rounded-lg shadow-lg hover:bg-teal-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets En Proceso</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestionProcess }}</p>
                            </div>

                            <!-- Tickets Objetados -->
                            <div class="bg-emerald-500 text-white p-6 rounded-lg shadow-lg hover:bg-emerald-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Objetados</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestionObjet }}</p>
                            </div>
                        
                            <!-- Tickets Solucionados -->
                            <div class="bg-emerald-500 text-white p-6 rounded-lg shadow-lg hover:bg-emerald-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Solucionados</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestionSolved }}</p>
                            </div>
                        
                            <!-- Tickets Cancelados -->
                            <div class="bg-amber-500 text-white p-6 rounded-lg shadow-lg hover:bg-amber-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets en Cancelados</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestionCancel }}</p>
                            </div>

                             <!-- Tickets en Bandeja -->
                             <div class="bg-amber-500 text-white p-6 rounded-lg shadow-lg hover:bg-amber-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets en Bandeja</p>
                                <p class="text-4xl mt-2">{{ $ticketsGestionTotal }}</p>
                            </div>
                        
                        </div>
                        
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos asignados.</p>
                    @endif

                </div>
            </div>
            
        </div>
        
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
    
                    @if (auth()->user()->getAllPermissions()->isNotEmpty())
                        <p class="text-2xl font-bold mb-6 text-center">Proceso de Todos los Requerimientos</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    
                            <!-- Tickets Pendientes -->
                            <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg hover:bg-red-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total Tickets Pendientes</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsPendientes }}</p>
                            </div>
                        
                            <!-- Tickets En gestión -->
                            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Total Tickets En Gestión</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsEnGestion }}</p>
                            </div>
                        
                            <!-- Tickets Solucionados -->
                            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Solucionados del dia</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsSolucionados }}</p>
                            </div>
                        
                            <!-- Tickets Cancelados -->
                            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Cancelados del dia</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsCancelados }}</p>
                            </div>
    
                            <!-- Total de Tickets en algún proceso -->
                            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg hover:bg-purple-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets en Proceso</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsEnProceso }}</p>
                            </div>

                            <!-- Total de Tickets en objetado -->
                            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg hover:bg-purple-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets objetado</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsObjetado }}</p>
                            </div>
                            
                            <!-- Total de Tickets del día -->
                            <div class="bg-teal-500 text-white p-6 rounded-lg shadow-lg hover:bg-teal-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets </p>
                                <p class="text-4xl mt-2">{{ $totalTickets}}</p>
                            </div>
    
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos asignados.</p>
                    @endif
    
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
    
                    @if (auth()->user()->getAllPermissions()->isNotEmpty())
                        <p class="text-2xl font-bold mb-6 text-center">Proceso de  los del dia Requerimientos</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    
                            <!-- Tickets Pendientes -->
                            <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg hover:bg-red-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total Tickets Pendientes</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsPendientesDelDia }}</p>
                            </div>
                        
                            <!-- Tickets En gestión -->
                            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Total Tickets En Gestión</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsEnGestionDelDia }}</p>
                            </div>
                        
                            <!-- Tickets Solucionados -->
                            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Solucionados del dia</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsSolucionadosDelDia }}</p>
                            </div>
                        
                            <!-- Tickets Cancelados -->
                            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold"> Cancelados del dia</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsCanceladosDelDia }}</p>
                            </div>
    
                            <!-- Total de Tickets en algún proceso -->
                            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg hover:bg-purple-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets en Proceso</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsEnProcesoDelDia }}</p>
                            </div>

                            <!-- Total de Tickets en objetado -->
                            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg hover:bg-purple-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets objetado</p>
                                <p class="text-4xl mt-2">{{ $totalTicketsObjetadoDelDia }}</p>
                            </div>
                            
                            <!-- Total de Tickets del día -->
                            <div class="bg-teal-500 text-white p-6 rounded-lg shadow-lg hover:bg-teal-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Total de Tickets </p>
                                <p class="text-4xl mt-2">{{ $totalTicketsDelDia}}</p>
                            </div>
    
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos asignados.</p>
                    @endif
    
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
