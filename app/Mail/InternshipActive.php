<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternshipActive extends Mailable
{
    use Queueable, SerializesModels;

    public $internship;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\Internship $internship)
    {
        $this->internship = $internship;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Magang Dibuka: Silakan Ambil ID Card',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.internship_active', // Changed to view directly
            with: [
                'name' => $this->internship->student->name,
                'startDate' => $this->internship->start_date,
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
