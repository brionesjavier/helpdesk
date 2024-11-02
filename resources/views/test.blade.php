<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="container">
        <h1>Reporte de SLA</h1>

        <table>
            <thead>
                <tr>
                    <th>Total de Tickets</th>
                    <th>Asignaciones Cumplidas</th>
                    <th>Soluciones Cumplidas</th>
                    <th>% Asignación Cumplida</th>
                    <th>% Solución Cumplida</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totalTickets }}</td>
                    <td>{{ $asignados }}</td>
                    <td>{{ $solucionados }}</td>
                    <td>{{ number_format($porcentajeAsignacion, 2) }}%</td>
                    <td>{{ number_format($porcentajeSolucion, 2) }}%</td>
                </tr>
            </tbody>
        </table>

        @if($totalTickets === 0)
            <p>No hay datos disponibles para mostrar.</p>
        @endif
    </div>
  {{--   <<div class="container">
        <h1>Reporte de SLA</h1>

        @if($resultados && count($resultados) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Prioridad</th>
                        <th>Total de Tickets</th>
                        <th>Asignaciones Cumplidas</th>
                        <th>Soluciones Cumplidas</th>
                        <th>% Asignación Cumplida</th>
                        <th>% Solución Cumplida</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado->priority }}</td>
                            <td>{{ $resultado->total_tickets }}</td>
                            <td>{{ $resultado->asignacion_cumplida }}</td>
                            <td>{{ $resultado->solucion_cumplida }}</td>
                            <td>{{ number_format($resultado->porcentaje_asignacion, 2) }}%</td>
                            <td>{{ number_format($resultado->porcentaje_solucion, 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay datos disponibles para mostrar.</p>
        @endif
    </div>
     --}}

</body>
</html>