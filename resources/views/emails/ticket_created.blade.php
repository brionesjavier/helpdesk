<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ticket Creado</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    
    <h1 style="color: #333;">Ticket Creado</h1>
    <div style="margin: 15px 0; padding: 10px; background-color: #f9f9f9; border-left: 5px solid #ccc;">
    <p>Estimado/a <strong>{{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</strong>,</p>
    
    <p>Tu ticket con el número <strong>{{ $ticket->id }}</strong> ha sido creado con éxito.</p>
    <p><strong>Fecha de creacion:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Título:</strong> {{ $ticket->title }}</p>
    <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
    <p><strong>Estado actual:</strong> {{ $ticket->state->name }}</p>
    <p><strong>Categoría:</strong> {{ $ticket->element->category->name }}</p>
    <p><strong>Elemento asociado:</strong> {{ $ticket->element->name }}</p>
    </div>
    <p>Nos pondremos en contacto contigo para cualquier actualización sobre tu ticket.</p>
    
    <p>Gracias,</p>
    <p><strong>El equipo de soporte</strong></p>

</body>
</html>