<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Notify extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_data, $status, $id;

    /**
     * Create a new message instance.
     */
    public function __construct($mail_data, $status, $id)
    {
        $this->mail_data = $mail_data;
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Request registration for NOC Service',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
            return new Content(
                view: 'emails.approve',
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
