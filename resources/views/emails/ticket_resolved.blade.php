<!DOCTYPE html>
<html>
<head>
    <title>Ticket Resuelto</title>
</head>
<body>
    <h1>Ticket Resuelto</h1>
    <div style="margin: 15px 0; padding: 10px; background-color: #f9f9f9; border-left: 5px solid #ccc;">
    <p>Estimado/a {{ $ticket->user->first_name }} {{ $ticket->user->last_name }},</p>
    <p>El ticket <strong>#{{ $ticket->id }}</strong> ha sido resuelto.</p>
    <p><strong>Fecha de actualización:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
    <p><strong>Título:</strong> {{ $ticket->title }}</p>
    <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
    <p><strong>Categoría:</strong> {{ $ticket->element->category->name }}</p>
    <p><strong>Elemento asociado:</strong> {{ $ticket->element->name }}</p>
    <p>El estado ha cambiado a: <strong>{{ $ticket->state->name }}</strong>.</p>
    </div>
    <p>Si tiene más preguntas o necesita más información, no dude en ponerse en contacto con nosotros.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte</p>
</body>
</html>
