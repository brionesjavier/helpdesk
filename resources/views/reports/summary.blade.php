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

                <div class="flex justify-between items-center">
                    <!-- Mostrar fecha buscada o fecha actual al lado izquierdo -->

                    <div class="text-lg font-semibold text-gray-700">
                        <h1 class="text-lg font-semibold mb-2">Resumen del Rango de Fechas</h1>
                        {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y') }}
                        -
                        {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y') }}
                    </div>

                    <!-- Formulario de búsqueda al lado derecho -->
                    <form action="{{ route('reports.summary') }}" method="GET" class="flex gap-4">
                        <!-- Filtro de fecha de inicio -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de
                                Inicio</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ request('start_date') ?? \Carbon\Carbon::now()->toDateString() }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-400 dark:text-white">
                        </div>

                        <!-- Filtro de fecha de fin -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ request('end_date') ?? \Carbon\Carbon::now()->toDateString() }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-400 dark:text-white">
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Aplicar Filtros
                            </button>
                            <a href="{{ route('reports.summary') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
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
                        <p>{{ $formattedAvgAttentionTime }} </p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">Tiempo Promedio de Solución</h2>
                        <p>{{ $formattedAvgResolutionTime }} </p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">SLA de Asignación</h2>
                        <p>{{ number_format($slaTickets['porcentajeAsignacion'], 2) }}% </p>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">SLA de Solución</h2>
                        <p>{{ number_format($slaTickets['porcentajeSolucion'], 2) }}% </p>
                    </div>
                </div>
            </div>

              <!-- Reporte SLA -->
  <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Reporte de SLA</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Total de Tickets</th>
                <th class="py-2 px-4 border-b text-left">Asignaciones Cumplidas</th>
                <th class="py-2 px-4 border-b text-left">Soluciones Cumplidas</th>
                <th class="py-2 px-4 border-b text-left">SLA Asignaciones</th>
                <th class="py-2 px-4 border-b text-left">SLA Solución </th>
            </tr>
        </thead>
        <tbody>
            @if ($slaAttentionByUser->isEmpty())
                <tr>
                    <td colspan="3" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.</td>
                </tr>
            @else
                
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $slaTickets['totalTickets']}}</td>
                        <td class="py-2 px-4 border-b">{{ $slaTickets['asignados']}}</td>
                        <td class="py-2 px-4 border-b">{{ $slaTickets['solucionados']}}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($slaTickets['porcentajeAsignacion'], 2) }}%</td>
                        <td class="py-2 px-4 border-b">{{ number_format($slaTickets['porcentajeSolucion'], 2) }}%</td>
                        
                    </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Reporte SLA por prioridad -->
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Reporte de SLA por Prioridad</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Prioridad</th>
                <th class="py-2 px-4 border-b text-left">Total de Tickets</th>
                <th class="py-2 px-4 border-b text-left">Asignaciones Cumplidas</th>
                <th class="py-2 px-4 border-b text-left">SLA Asignación</th>
                <th class="py-2 px-4 border-b text-left">Soluciones Cumplidas</th>
                
                <th class="py-2 px-4 border-b text-left">SLA Solución</th>
            </tr>
        </thead>
        <tbody>
            
            @forelse ($slaPriority as $resultado)
                <tr>
                    <td class="py-2 px-4 border-b text-left">{{ $resultado->priority }}</td>
                    <td class="py-2 px-4 border-b text-left">{{ $resultado->total_tickets }}</td>
                    <td class="py-2 px-4 border-b text-left">{{ $resultado->asignacion_cumplida }}</td>
                    <td class="py-2 px-4 border-b text-left">{{ number_format($resultado->porcentaje_asignacion, 2) }}%</td>
                    <td class="py-2 px-4 border-b text-left">{{ $resultado->solucion_cumplida }}</td>
                    
                    <td class="py-2 px-4 border-b text-left">{{ number_format($resultado->porcentaje_solucion, 2) }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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

           <!-- Prioridad de los Tickets -->
<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Prioridad de los Tickets</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Prioridad</th>
                <th class="py-2 px-4 border-b text-left">Cantidad</th>
                <th class="py-2 px-4 border-b text-left">Descripción</th>
                <th class="py-2 px-4 border-b text-left">Plazo SLA </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-green-100">
                <td class="py-2 px-4 border-b">Baja (low)</td>
                <td class="py-2 px-4 border-b">{{ $ticketsBajos }}</td> <!-- Asegúrate de que esta variable esté definida -->
                <td class="py-2 px-4 border-b">Tickets con baja prioridad.</td>
                <td class="py-2 px-4 border-b">48 horas</td>
            </tr>
            <tr class="bg-orange-100">
                <td class="py-2 px-4 border-b">Media (medium)</td>
                <td class="py-2 px-4 border-b">{{ $ticketsMedios }}</td> <!-- Asegúrate de que esta variable esté definida -->
                <td class="py-2 px-4 border-b">Tickets con prioridad media.</td>
                <td class="py-2 px-4 border-b">24 horas</td>
            </tr>
            <tr class="bg-yellow-100">
                <td class="py-2 px-4 border-b">Alta (high)</td>
                <td class="py-2 px-4 border-b">{{ $ticketsAltos }}</td> <!-- Asegúrate de que esta variable esté definida -->
                <td class="py-2 px-4 border-b">Tickets con alta prioridad.</td>
                <td class="py-2 px-4 border-b">8 horas.</td>
            </tr>
            <tr class="bg-red-100">
                <td class="py-2 px-4 border-b">Crítica (critical)</td>
                <td class="py-2 px-4 border-b">{{ $ticketsCriticos }}</td> <!-- Asegúrate de que esta variable esté definida -->
                <td class="py-2 px-4 border-b">Tickets con prioridad crítica.</td>
                <td class="py-2 px-4 border-b">4 horas</td>
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
                        @if ($ticketsByCategory->isEmpty())
                            <tr>
                                <td colspan="2" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.
                                </td>
                            </tr>
                        @else
                            @foreach ($ticketsByCategory as $item)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $item->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Tickets por Elemento -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets por Elemento</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left w-1/3">Elemento</th>
                            <th class="py-2 px-4 border-b text-left w-1/3">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ticketsByElement->isEmpty())
                            <tr>
                                <td colspan="2" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.
                                </td>
                            </tr>
                        @else
                            @foreach ($ticketsByElement as $item)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $item->element }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        @endif
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
                            <th class="py-2 px-4 border-b text-left">Tickets Activos Asignados</th>
                            <th class="py-2 px-4 border-b text-left">Tickets Reasignados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ticketsByUser->isEmpty())
                            <tr>
                                <td colspan="4" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.
                                </td>
                            </tr>
                        @else
                            @foreach ($ticketsByUser as $item)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $item->first_name }} {{ $item->last_name }}
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ abs($item->total) }}</td>
                                    <td class="py-2 px-4 border-b">{{ abs($item->finalizado) }}</td>
                                    <td class="py-2 px-4 border-b">{{ abs($item->total - $item->finalizado) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Tickets reasignados -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets Reasignados (Más de Una Vez)</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-6 border-b text-left w-1/3">Folio</th>
                            <th class="py-2 px-6 border-b text-left w-1/3">Cantidad de Reasignaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ticketsMultipleAssignments->isEmpty())
                            <tr>
                                <td colspan="2" class="py-2 px-6 text-center">No hay datos disponibles para
                                    mostrar.</td>
                            </tr>
                        @else
                            @foreach ($ticketsMultipleAssignments as $item)
                                <tr>
                                    <td class="py-2 px-6 border-b"><a
                                            href="{{ route('reports.sla', $item->ticket_id) }}">
                                            {{ $item->ticket_id }} </a></td>
                                    <td class="py-2 px-6 border-b">{{ $item->total_assignments - 1 }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>


            <!-- Tickets En Proceso y Objetado -->
            <<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Tickets En Proceso y Objetado</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">ID</th>
                            <th class="py-2 px-4 border-b text-left">Usuario</th>
                            <th class="py-2 px-4 border-b text-left">Tickets en Proceso</th>
                            <th class="py-2 px-4 border-b text-left">Tickets Objetados</th>
                            <th class="py-2 px-4 border-b text-left">Total de Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($supportTickets->isEmpty())
                            <tr>
                                <td colspan="5" class="py-2 px-6 text-center">No hay datos disponibles para
                                    mostrar.</td>
                            </tr>
                        @else
                            @foreach ($supportTickets as $item)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $item->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->first_name }} {{ $item->last_name }}
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $item->process_tickets }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->obj_tickets }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->total_tickets }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
        </div>

        <!-- Tickets  Objetado -->
        <<div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Tickets Objetado (Más de Una Vez)</h2>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left w-1/3">Folio</th>
                        <th class="py-2 px-4 border-b text-left w-1/3">Total de objeciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ticketsObjetadosCount->isEmpty())
                        <tr>
                            <td colspan="2" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.
                            </td>
                        </tr>
                    @else
                        @foreach ($ticketsObjetadosCount as $item)
                            <tr>
                                <td class="py-2 px-4 border-b"><a
                                        href="{{ route('reports.sla', $item->ticket_id) }}"> {{ $item->ticket_id }}
                                    </a></td>
                                <td class="py-2 px-4 border-b">{{ $item->total_objeciones }}</td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
    </div>


    <!-- SLA de Atención por Usuario incluy-->
    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Tiempo Promedio de Asignación por Usuario</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">Usuario</th>
                    <th class="py-2 px-4 border-b text-left">Promedio Asignación (minutos)</th>
                    <th class="py-2 px-4 border-b text-left">Cantidad de Tickets</th>
                </tr>
            </thead>
            <tbody>
                @if ($slaAttentionByUser->isEmpty())
                    <tr>
                        <td colspan="3" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.</td>
                    </tr>
                @else
                    @foreach ($slaAttentionByUser as $user)
                        <tr @class([
                            'bg-green-100' => abs($user->avg_attention_time) <= 20,
                            'bg-yellow-100' =>
                                abs($user->avg_attention_time) > 20 && $user->avg_attention_time <= 30,
                            'bg-red-100' => abs($user->avg_attention_time) > 30,
                        ])>
                            <td class="py-2 px-4 border-b">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->getFormattedSla($user->avg_attention_time) }}
                            </td>
                            <td class="py-2 px-4 border-b">{{ abs($user->total) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- SLA de Solución por Usuario -->
  {{--   <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">tiempo Promedio del procesp para Resolución (Incluye Todo el Proceso,
            Excluyendo la Primera Asignación)</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">Usuario</th>
                    <th class="py-2 px-4 border-b text-left">Promedio Solución (minutos)</th>
                    <th class="py-2 px-4 border-b text-left">Cantidad de Tickets</th>
                </tr>
            </thead>
            <tbody>
                @if ($slaResolutionByUser->isEmpty())
                    <tr>
                        <td colspan="3" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.</td>
                    </tr>
                @else
                    @foreach ($slaResolutionByUser as $user)
                        <tr @class([
                            'bg-green-100' => abs($user->avg_resolution_time) <= 20,
                            'bg-yellow-100' =>
                                abs($user->avg_resolution_time) > 20 &&
                                $user->avg_resolution_time <= 30,
                            'bg-red-100' => abs($user->avg_resolution_time) > 30,
                        ])>
                            <td class="py-2 px-4 border-b">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->getFormattedSla($user->avg_resolution_time) }}
                            </td>
                            <td class="py-2 px-4 border-b">{{ $user->total }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div> --}}

    <!-- SLA de Solución por Usuario -->
    <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Tiempo Promedio  de Solución por Usuario</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">Usuario</th>
                    <th class="py-2 px-4 border-b text-left">Promedio Solución (minutos)</th>
                    <th class="py-2 px-4 border-b text-left">Cantidad de Tickets</th>
                </tr>
            </thead>
            <tbody>
                @if ($slaResolutionByUser->isEmpty())
                    <tr>
                        <td colspan="3" class="py-2 px-6 text-center">No hay datos disponibles para mostrar.</td>
                    </tr>
                @else
                    @foreach ($TimesSolvedByUser as $user)
                        <tr @class([
                            'bg-green-100' => abs($user->avg_resolution_time) <= 20,
                            'bg-yellow-100' =>
                                abs($user->avg_resolution_time) > 20 &&
                                $user->avg_resolution_time <= 30,
                            'bg-red-100' => abs($user->avg_resolution_time) > 30,
                        ])>
                            <td class="py-2 px-4 border-b">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-2 px-4 border-b">{{$user->getFormattedSla( $user->avgsolutionbyuser) }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->total }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>


    </div>
    </div>
</x-app-layout>
