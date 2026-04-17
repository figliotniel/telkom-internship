<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyLogbookDigest extends Mailable
{
    use Queueable, SerializesModels;

    public $mentor;
    public $studentsData;

    /**
     * Create a new message instance.
     */
    public function __construct($mentor, $studentsData)
    {
        $this->mentor = $mentor;
        $this->studentsData = $studentsData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat: Evaluasi Logbook Harian Magang',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly_logbook_digest',
            with: [
                'mentor' => $this->mentor,
                'studentsData' => $this->studentsData,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
