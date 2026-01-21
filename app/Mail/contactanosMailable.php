<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $archivoPath;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $archivoPath = null)
    {
        $this->data = $data;
        $this->archivoPath = $archivoPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('oswaldo@mail.com', 'oswaldo ramirez'),
            subject: 'Contactanos mailable',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contactanos',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->archivoPath) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->archivoPath);
        }
        
        return $attachments;
    }
}
