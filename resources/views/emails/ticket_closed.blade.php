<!DOCTYPE html>
<html>
<head>
    <title>Ticket Cerrado</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    
    <h1 style="color: #333;">Ticket Cerrado</h1>
    <div style="margin: 15px 0; padding: 10px; background-color: #f9f9f9; border-left: 5px solid #ccc;">
    <p>Estimado/a <strong>{{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</strong>,</p>

    <p>Le informamos que el ticket <strong>#{{ $ticket->id }}</strong> ha sido cerrado.</p>

    <p><strong>Fecha de actualización:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>

    <p><strong>Título:</strong> {{ $ticket->title }}</p>

    <p><strong>Descripción:</strong> {{ $ticket->description }}</p>

    <p><strong>Prioridad:</strong> {{ ucfirst($ticket->priority) }}</p>

    <p><strong>Estado actual:</strong> {{ $ticket->state->name }}</p>
    </div>

    <p>Gracias por usar nuestro servicio. Si necesita más asistencia, no dude en crear un nuevo ticket.</p>

    <p>Gracias,</p>

    <p><strong>El equipo de soporte</strong></p>

</body>
</html>
