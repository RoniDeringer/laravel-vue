<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;

    public string $messageText;

    public function __construct(
        string $subject,
        string $message,
    ) {
        $this->emailSubject = $subject;
        $this->messageText = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.study',
            with: [
                'messageText' => $this->messageText,
            ],
        );
    }
}