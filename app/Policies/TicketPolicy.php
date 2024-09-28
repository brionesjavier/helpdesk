<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
       /**
     * Determina si el usuario asignado activamente puede gestionar el ticket.
     */
    public function manage(User $user, Ticket $ticket)
    {
        // Verifica si el usuario autenticado está asignado activamente al ticket
        return $ticket->assignedUsers()->wherePivot('is_active', true)->get()->contains('id', $user->id);
    }

       /**
     * Determina si el usuario asignado activamente puede gestionar el ticket.
     */
    public function createByUser(User $user, Ticket $ticket)
    {
        // Verifica si el usuario autenticado está asignado activamente al ticket
        return $ticket->created_by === $user->id;
    }

    public function manageOrCreateByUser(User $user, Ticket $ticket)
{
    // Verificar si el usuario es el creador del ticket
    $isCreator = $ticket->created_by === $user->id;

    // Verificar si el usuario está asignado activamente al ticket
    $isAssignedActive = $ticket->assignedUsers()
        ->wherePivot('is_active', true)
        ->get()
        ->contains('id', $user->id);

    // Permitir si el usuario es el creador o está asignado activamente
    return $isCreator || $isAssignedActive;
}
 

    
}
