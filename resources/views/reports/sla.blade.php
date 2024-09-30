<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Historial de Acciones y Tiempos SLA
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($histories->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">No hay historial disponible.</p>
                    @else
                        <!-- Muestra el tiempo total de SLA -->
                        <div class="mb-6">
                            <p class="font-bold text-lg">Tiempo total de SLA: <span class="text-blue-600 dark:text-blue-400">{{ $ticket->getTotalSlaTime() }} </span></p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acción</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Responsable</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">SLA del Cambio (minutos)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($histories as $history)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $history->state->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $history->action }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $history->user->first_name }} {{ $history->user->last_name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $history->change_state ? ($history->getFormattedSla($history->sla_time) ?? 'Pendiente') : 'N/A' }}
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
