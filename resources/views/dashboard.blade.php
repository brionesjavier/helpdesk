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
                                <p class="text-4xl mt-2">{{ $ticketsPendientes }}</p>
                            </div>
                        
                            <!-- Tickets En Proceso -->
                            <div class="bg-teal-500 text-white p-6 rounded-lg shadow-lg hover:bg-teal-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets En Proceso</p>
                                <p class="text-4xl mt-2">{{ $ticketsEnProceso }}</p>
                            </div>
                        
                            <!-- Tickets Solucionados -->
                            <div class="bg-emerald-500 text-white p-6 rounded-lg shadow-lg hover:bg-emerald-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Solucionados</p>
                                <p class="text-4xl mt-2">{{ $ticketsSolucionados }}</p>
                            </div>
                        
                            <!-- Tickets Cancelados -->
                            <div class="bg-amber-500 text-white p-6 rounded-lg shadow-lg hover:bg-amber-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <p class="text-xl font-semibold">Tickets en Bandeja</p>
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
</x-app-layout>
