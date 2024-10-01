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
    public $message;
    public $user ;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param string $message
     */
    public function __construct(Ticket $ticket, string $message, User $user)
    {
        $this->ticket = $ticket;
        $this->message = $message;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Notificación de Ticket: #' . $this->ticket->id)
                    ->view('emails.ticket_notification');
    }
    
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}