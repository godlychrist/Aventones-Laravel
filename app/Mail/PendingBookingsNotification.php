<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Collection;

class PendingBookingsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $driver;
    public Collection $bookings;
    public int $minutes;

    /**
     * Create a new message instance.
     */
    public function __construct(User $driver, Collection $bookings, int $minutes)
    {
        $this->driver = $driver;
        $this->bookings = $bookings;
        $this->minutes = $minutes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $count = $this->bookings->count();
        $subject = $count === 1 
            ? 'Tienes 1 solicitud de reserva pendiente' 
            : "Tienes {$count} solicitudes de reserva pendientes";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Mail.PendingBookingsNotification',
            with: [
                'driver' => $this->driver,
                'bookings' => $this->bookings,
                'minutes' => $this->minutes,
            ],
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
