<?php
namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $customMessage; // Renombrar de $message a $customMessage
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param string $customMessage
     * @param User $user
     */
    public function __construct(Ticket $ticket, string $customMessage, User $user)
    {
        $this->ticket = $ticket;
        $this->customMessage = $customMessage; // Renombrar de $message a $customMessage
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Notificación de Ticket: #' . $this->ticket->id)
                    ->view('emails.ticket_notification');
    }

    public function attachments(): array
    {
        return [];
    }
}
