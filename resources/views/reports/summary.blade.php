<x-app-layout>
    <x-slot name="header">
        @if (session()->has('message'))
            <div class="text-center bg-gray-100 rounded-md p-2 mb-4">
                <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Informe de Tickets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Fecha y Hora Actual -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-lg font-semibold mb-2">Fecha y Hora Actual</h1>
                <p>{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>

            <!-- Resumen General -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold mb-4">Resumen General</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold">Total de Tickets</h2>
                        <p>{{ $totalTickets }}</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">Tickets Pendientes</h2>
                        <p>{{ $ticketsPendientes }}</p>
                    </div>
                    
                    
                    <div>
                        <h2 class="text-xl font-semibold">Tiempo Promedio de Asignación</h2>
                        <p>{{ round(abs($avgAttentionTime), 2) }} minutos</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">Tiempo Promedio de Solución</h2>
                        <p>{{ round(abs($avgResolutionTime), 2) }} minutos</p>
                    </div>
                </div>
            </div>
            <!-- Estados de los Tickets -->
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Estado de los Tickets</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Estado</th>
                <th class="py-2 px-4 border-b text-left">Cantidad</th>
                <th class="py-2 px-4 border-b text-left">Descripción</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-green-100">
                <td class="py-2 px-4 border-b">Solucionado</td>
                <td class="py-2 px-4 border-b">{{ $ticketsSolucionados }}</td>
                <td class="py-2 px-4 border-b">Tickets que han sido solucionados.</td>
            </tr>
            <tr class="bg-yellow-100">
                <td class="py-2 px-4 border-b">En Proceso</td>
                <td class="py-2 px-4 border-b">{{ $ticketsEnProceso }}</td>
                <td class="py-2 px-4 border-b">Tickets que están actualmente en proceso de resolución.</td>
            </tr>
            <tr class="bg-orange-100">
                <td class="py-2 px-4 border-b">Pendiente</td>
                <td class="py-2 px-4 border-b">{{ $ticketsPendientes }}</td>
                <td class="py-2 px-4 border-b">Tickets que están pendientes de atención.</td>
            </tr>
            <tr class="bg-red-100">
                <td class="py-2 px-4 border-b">Cancelado</td>
                <td class="py-2 px-4 border-b">{{ $ticketsCancelados }}</td>
                <td class="py-2 px-4 border-b">Tickets que han sido cancelados.</td>
            </tr>
            <tr class="bg-gray-100">
                <td class="py-2 px-4 border-b">Objetado</td>
                <td class="py-2 px-4 border-b">{{ $ticketsObjetados }}</td>
                <td class="py-2 px-4 border-b">Tickets que han sido objetados.</td>
            </tr>
        </tbody>
    </table>
</div>


            <!-- Tickets por Categoría -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets por Categoría</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Categoría</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsByCategory as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tickets por Elemento -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets por Elemento</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Elemento</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsByElement as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->element }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tickets por Prioridad -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets por Prioridad</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Prioridad</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsByPriority as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->priority }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tickets Asignados por Usuario -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets Asignados por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Usuario</th>
                            <th class="py-2 px-4 border-b text-left">Total de Tickets Asignados</th>
                            <th class="py-2 px-4 border-b text-left">Tickets Activos</th>
                            <th class="py-2 px-4 border-b text-left">Tickets Reasignados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsByUser as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->first_name }} {{ $item->last_name }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->total) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->finalizado) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->total - $item->finalizado) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tickets reasignados -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets Reasignados</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Folio</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad Reasignados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsMultipleAssignments as $item)
                            <tr>
                                
                                <td class="py-2 px-4 border-b"><a href="{{ route('reports.sla',$item->ticket_id) }}">{{ $item->ticket_id }}</a></td>
                                <td class="py-2 px-4 border-b">{{ $item->total_assignments-1}}</td>
                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SLA de Atención por Usuario -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">SLA de Asignación Promedio por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Usuario</th>
                            <th class="py-2 px-4 border-b text-left">Promedio Asignación (minutos)</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad de Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slaAttentionByUser as $user)
                            <tr @class([
                                'bg-green-100' => abs($user->avg_attention_time) <= 20,
                                'bg-yellow-100' => abs($user->avg_attention_time) > 20 && $user->avg_attention_time <= 30,
                                'bg-red-100' => abs($user->avg_attention_time) > 30,
                            ])>
                                <td class="py-2 px-4 border-b">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="py-2 px-4 border-b">{{ round(abs($user->avg_attention_time), 2) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($user->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SLA de Solución por Usuario -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">SLA de Solución Promedio por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Usuario</th>
                            <th class="py-2 px-4 border-b text-left">Promedio Solución (minutos)</th>
                            <th class="py-2 px-4 border-b text-left">Cantidad de Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slaResolutionByUser as $user)
                            <tr @class([
                                'bg-green-100' => abs($user->avg_resolution_time) <= 20,
                                'bg-yellow-100' => abs($user->avg_resolution_time) > 20 && $user->avg_resolution_time <= 30,
                                'bg-red-100' => abs($user->avg_resolution_time) > 30,
                            ])>
                                <td class="py-2 px-4 border-b">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="py-2 px-4 border-b">{{ round(abs($user->avg_resolution_time), 2) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($user->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
