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
    public $inductionData;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\Internship $internship, $inductionData)
    {
        $this->internship = $internship;
        $this->inductionData = $inductionData;
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
            view: 'emails.internship_active',
            with: [
                'name' => $this->internship->student->name,
                'startDate' => $this->internship->start_date,
                'inductionDate' => $this->inductionData['date'],
                'inductionTime' => $this->inductionData['time'],
                'location' => $this->inductionData['location'],
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
