<x-app-layout>
    <x-slot name="header">
        @if(session()->has('message'))
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
            
            <!-- Resumen General -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold mb-4">Resumen General</h1>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">Total de Tickets</h2>
                    <p>{{ $totalTickets }}</p>
                </div>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">Tiempo Promedio de Asignación</h2>
                    <p>{{ round(abs($avgAttentionTime), 2) }} minutos</p>
                </div>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">Tiempo Promedio de Solución (sin incluir el tiempo de Asignación)</h2>
                    <p>{{ round(abs($avgResolutionTime), 2) }} minutos</p>
                </div>
            </div>

            <!-- Tickets por Categoría -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold">Tickets por Categoría</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Categoría</th>
                            <th class="py-2 px-4 border-b">Cantidad</th>
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
                <h2 class="text-xl font-semibold">Tickets por Elemento</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Elemento</th>
                            <th class="py-2 px-4 border-b">Cantidad</th>
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
                <h2 class="text-xl font-semibold">Tickets por Prioridad</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Prioridad</th>
                            <th class="py-2 px-4 border-b">Cantidad</th>
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
                <h2 class="text-xl font-semibold">Tickets Asignados por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Usuario</th>
                            <th class="py-2 px-4 border-b">total de Tickets Asignados</th>
                            <th class="py-2 px-4 border-b">Tickets Activos</th>
                            <th class="py-2 px-4 border-b">Tickets Reasignados</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsByUser as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->first_name }} {{ $item->last_name }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->total) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->finalizado) }}</td>
                                <td class="py-2 px-4 border-b">{{ abs($item->total-$item->finalizado)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SLA de Atención por Usuario -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold">SLA de Asignacion Promedio por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Usuario</th>
                            <th class="py-2 px-4 border-b">Promedio Asignacion (minutos)</th>
                            <th class="py-2 px-4 border-b">Cantidad de Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slaAttentionByUser as $user)
                            <tr @class([
                                'bg-green-100' => abs($user->avg_attention_time) <= 20,
                                'bg-yellow-100' => abs($user->avg_attention_time) > 20 && $user->avg_attention_time <= 30,
                                'bg-red-100' => abs($user->avg_attention_time) > 30
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
                <h2 class="text-xl font-semibold">SLA de Solución Promedio por Usuario</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Usuario</th>
                            <th class="py-2 px-4 border-b">Promedio Solución (minutos)</th>
                            <th class="py-2 px-4 border-b">Cantidad de Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slaResolutionByUser as $user)
                            <tr @class([
                                'bg-green-100' => abs($user->avg_resolution_time) <= 20,
                                'bg-yellow-100' => abs($user->avg_resolution_time) > 20 && $user->avg_resolution_time <= 30,
                                'bg-red-100' => abs($user->avg_resolution_time) > 30
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
