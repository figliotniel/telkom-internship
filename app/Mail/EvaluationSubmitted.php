<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $internship;
    public $evaluation;

    /**
     * Create a new message instance.
     */
    public function __construct($internship, $evaluation)
    {
        $this->internship = $internship;
        $this->evaluation = $evaluation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan: Nilai Magang Telah Keluar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.evaluation_submitted',
            with: [
                'internship' => $this->internship,
                'evaluation' => $this->evaluation,
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
