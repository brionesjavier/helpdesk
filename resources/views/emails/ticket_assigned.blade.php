<!DOCTYPE html>
<html>
<head>
    <title>Ticket {{ $ticket->state->name }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h1 style="color: #333;">Ticket {{ $ticket->state->name }}</h1>

    @foreach($ticket->assignedUsers as $assignment)
        @if($assignment->pivot->is_active) <!-- Mostrar solo asignaciones activas -->
            <div style="margin: 15px 0; padding: 10px; background-color: #f9f9f9; border-left: 5px solid #ccc;">
                <p><strong>Estimado/a {{ $assignment->first_name }} {{ $assignment->last_name }},</strong></p>
                <p>Le informamos que el ticket <strong>#{{ $ticket->id }}</strong> ha sido asignado a usted.</p>
                <p><strong>Fecha de asignación:</strong> {{ $assignment->pivot->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Título:</strong> {{ $ticket->title }}</p>
                <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
                <p><strong>Prioridad:</strong> {{ ucfirst($ticket->priority) }}</p>
                <p><strong>Estado actual:</strong> {{ $ticket->state->name }}</p>
                <p><strong>Detalles de la asignación:</strong></p>
                <p>{{ $assignment->pivot->details }}</p>
            </div>
        @endif
    @endforeach
    
    <p>Por favor, revise los detalles y tome las medidas necesarias para continuar con el proceso de soporte.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte</p>
</body>
</html>
