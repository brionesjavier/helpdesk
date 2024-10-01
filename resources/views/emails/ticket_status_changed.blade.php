<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Estado del Ticket</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    
    <h1 style="color: #333;">Cambio de Estado del Ticket</h1>
    
    <p>Estimado/a <strong>{{ $ticket->createdBy->name }}</strong>,</p>
    
    <p>El estado del ticket <strong>#{{ $ticket->id }}</strong> ha cambiado.</p>
    
    <p><strong>Título:</strong> {{ $ticket->title }}</p>
    <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
    
    <p>El nuevo estado es: <strong>{{ $ticket->state->name }}</strong>.</p> <!-- Corrigido: se cambió > a . -->
    
    <p>Por favor, revise el ticket para más detalles.</p>
    
    <p>Gracias por su atención.</p>
    
    <p>Saludos,</p>
    <p><strong>El equipo de soporte</strong></p>

</body>
</html>
