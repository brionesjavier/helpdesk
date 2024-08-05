@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Tickets</h1>

        @if($tickets->isEmpty())
            <p>No hay tickets disponibles.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Creado Por</th>
                        <th>Asignado A</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->description }}</td>
                            <td>{{ $ticket->creator ? $ticket->creator->name : 'Desconocido' }}</td>
                            <td>{{ $ticket->assignedUser ? $ticket->assignedUser->name : 'No asignado' }}</td>
                            <td>{{ $ticket->state ? $ticket->state->name : 'Desconocido' }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">Ver</a>
                                <!-- Añadir otros enlaces de acción si es necesario -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
