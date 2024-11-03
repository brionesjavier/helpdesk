<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (auth()->user()->getAllPermissions()->isNotEmpty())
    {{-- dashboard user --}}
    @can('tickets.my')
        
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">


                        <p class="text-xl font-semibold mb-4">Proceso de Mis Requerimientos</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 ">

                            <!-- Tickets Pendientes -->
                            <div
                                class="bg-gradient-to-r from-red-400 to-red-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Pendientes</p>
                                <p class="text-4xl mt-2">{{ $ticketsPendientes }}</p>
                            </div>

                            <!-- Tickets En Proceso -->
                            <div
                                class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                <p class="text-xl font-semibold">Tickets En Proceso</p>
                                <p class="text-4xl mt-2">{{ $ticketsEnProceso }}</p>
                            </div>

                            <!-- Tickets Solucionados -->
                            <div
                                class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Solucionados</p>
                                <p class="text-4xl mt-2">{{ $ticketsSolucionados }}</p>
                            </div>

                            <!-- Tickets Cancelados -->
                            <div
                                class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                <p class="text-xl font-semibold">Tickets Cancelados</p>
                                <p class="text-4xl mt-2">{{ $ticketsCancelados }}</p>
                            </div>

                        </div>


                    </div>
                </div>

            </div>

        </div>
        @endcan
{{-- dashboard soporte --}}
@can('support.assigned')
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">

                        @if (auth()->user()->getAllPermissions()->isNotEmpty())
                            <p class="text-xl font-semibold mb-4"> Requerimientos agente soporte</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-6">

                                <!-- Tickets Asignados / Derivado /objetado-->
                                <div
                                    class="bg-gradient-to-r from-purple-400 to-purple-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold"> Tickets en Gestión</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestion }}</p>
                                </div>

                                <!-- Tickets En Proceso -->
                                <div
                                    class="bg-gradient-to-r from-indigo-400 to-indigo-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold">Tickets En Proceso</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestionProcess }}</p>
                                </div>

                                <!-- Tickets Objetados -->
                                <div
                                    class="bg-gradient-to-r from-pink-400 to-pink-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold">Tickets Objetados</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestionObjet }}</p>
                                </div>

                                <!-- Tickets Solucionados -->
                                <div
                                    class="bg-gradient-to-r from-emerald-400 to-emerald-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"">
                                    <p class="text-xl font-semibold">Tickets Solucionados</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestionSolved }}</p>
                                </div>

                                <!-- Tickets Cancelados -->
                                <div
                                    class="bg-gradient-to-r from-amber-400 to-amber-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold">Tickets en Cancelados</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestionCancel }}</p>
                                </div>

                                <!-- Tickets en Bandeja -->
                                <div
                                    class="bg-gradient-to-r from-stone-400 to-stone-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold">Tickets en Bandeja</p>
                                    <p class="text-4xl mt-2">{{ $ticketsGestionTotal }}</p>
                                </div>

                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos
                                asignados.</p>
                        @endif

                    </div>
                </div>

            </div>

        </div>
        @endcan
        {{-- dashboard ticket en atencion--}}
        @can('support.index')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        @if (auth()->user()->getAllPermissions()->isNotEmpty())
                            <p class="text-2xl font-bold mb-6 text-center">Proceso de Todos los Tickes</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:cols-6 gap-6">


                                <!-- Tickets Pendientes -->
                                <div
                                    class="bg-gradient-to-r from-rose-400 to-rose-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Total Tickets Pendientes</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsPendientes }}</p>
                                </div>

                                <!-- Tickets En gestión -->
                                <div
                                    class="bg-gradient-to-r from-violet-400 to-violet-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center"> Total Tickets En Gestión</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsEnGestion }}</p>
                                </div>

                                <!-- Total de Tickets en algún proceso -->
                                <div
                                    class="bg-gradient-to-r from-sky-400 to-sky-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Total Tickets en Proceso</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsEnProceso }}</p>
                                </div>

                                <!-- Total de Tickets en objetado -->
                                <div
                                    class="bg-gradient-to-r from-pink-400 to-pink-600 text-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Total Tickets objetado</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsObjetado }}</p>
                                </div>


                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos
                                asignados.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endcan
{{-- dashboard del dia --}}
@can('support.index')
    

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        @if (auth()->user()->getAllPermissions()->isNotEmpty())
                            <p class="text-2xl font-bold mb-6 text-center">Control de Estado de Tickets del dia</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">

                                <!-- Tickets Pendientes -->
                                <div
                                    class="bg-gradient-to-r from-red-400 to-rose-600 text-white p-6 rounded-full shadow-full hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Pendientes</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsPendientesDelDia }}</p>
                                </div>

                                <!-- Tickets En gestión -->
                                <div
                                    class="bg-gradient-to-r from-purple-400 to-violet-600 text-white p-6 rounded-full shadow-full hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">En Gestión</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsEnGestionDelDia }}</p>
                                </div>

                                <!-- Total de Tickets en algún proceso -->
                                <div
                                    class="bg-gradient-to-r from-blue-400 to-sky-600 text-white p-6 rounded-full shadow-full hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">En Proceso</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsEnProcesoDelDia }}</p>
                                </div>

                                <!-- Total de Tickets en objetado -->
                                <div
                                    class="bg-gradient-to-r from-pink-400 to-pink-600 text-white p-6 rounded-full shadow-full hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Objetado</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsObjetadoDelDia }}</p>
                                </div>

                                <!-- Tickets Solucionados -->
                                <div
                                    class="bg-gradient-to-r from-emerald-400 to-emerald-600 text-white p-6 rounded-full shadow-full hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Solucionados</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsSolucionadosDelDia }}</p>
                                </div>

                                <!-- Tickets Cancelados -->
                                <div
                                    class="bg-gradient-to-r from-amber-400 to-amber-600 text-white p-6 rounded-full shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                                    <p class="text-xl font-semibold text-center">Cancelados</p>
                                    <p class="text-4xl mt-2 text-center">{{ $totalTicketsCanceladosDelDia }}</p>
                                </div>


                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos
                                asignados.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endcan
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <p class="text-center text-gray-500 dark:text-gray-400">El usuario no tiene permisos asignados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
