<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Ticket</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h1>Notificación para el Ticket #{{ $ticket->id }}</h1>
    <div style="margin: 15px 0; padding: 10px; background-color: #f9f9f9; border-left: 5px solid #ccc;">
        <p>Estimado/a {{ $ticket->user->first_name }} {{ $ticket->user->last_name }},</p>
        <div style="margin: 15px 0; padding: 10px; background-color: #e0f7fa; border-left: 5px solid #009687f3; color: #333;">
            <p>Tienes un nuevo mensaje en tu ticket de {{ $user->first_name }} {{ $user->last_name }}.</p>
            <p>{{ $customMessage }}</p> <!-- Cambiar de $message a $customMessage -->
        </div>  
        <p><strong>Fecha de actualización:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
        <p><strong>Título:</strong> {{ $ticket->title }}</p>
        <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
        <p><strong>Estado:</strong> {{ $ticket->state->name }}</p>
    </div>
    <p>Gracias por utilizar nuestro servicio. Si tiene más preguntas, no dude en contactarnos.</p>
    <p>Saludos,<br>El equipo de soporte</p>
</body>
</html>
