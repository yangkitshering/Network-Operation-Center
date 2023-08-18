<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class UserApprovalNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_data;
    public $pdf;
    public $status;
    /**
     * Create a new message instance.
     */
    public function __construct($mail_data, $pdf, $status)
    {
        $this->mail_data = $mail_data;
        $this->pdf = $pdf;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Approval Notify',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_approval_notify',
            
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->status == 1){
            return [
                Attachment::fromStorage($this->pdf),
            ];
        }  else{
            return [
                
            ];
        }
    }
}
