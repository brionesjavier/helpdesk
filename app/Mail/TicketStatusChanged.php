<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $view;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param string $view
     * @param string $subject
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        // Determina la vista y el asunto en función del estado del ticket
        switch ($this->ticket->state->id) {
            case '2':
                $view = 'emails.ticket_assigned';
                $this->subject = 'Notificación del Ticket #' . $this->ticket->id; // Ticket asignado
                break;
            case '4':
                $view = 'emails.ticket_resolved';
                $this->subject = 'Actualización del Ticket #' . $this->ticket->id; // Ticket resuelto
                break;
            case '1':
                $view = 'emails.ticket_created';
                $this->subject = 'Detalles del Ticket #' . $this->ticket->id; // Ticket creado
                break;
            case '7':
                $view = 'emails.ticket_closed';
                $this->subject = 'Estado del Ticket #' . $this->ticket->id; // Ticket cerrado
                break;
            case '5':
                $view = 'emails.ticket_reopened';
                $this->subject = 'Notificación del Ticket #' . $this->ticket->id; // Ticket reabierto
                break;
            case '6':
                $view = 'emails.ticket_assigned';
                $this->subject = 'Acción Requerida: Ticket #' . $this->ticket->id; // Requiere acción
                break;
            default:
                $view = 'emails.ticket_status_changed';
                $this->subject = 'Notificación  sobre el Ticket #' . $this->ticket->id; // Estado cambiado
                break;
        }
    
        return $this->subject($this->subject)
            ->view($view);
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->view,
        );
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
