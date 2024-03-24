<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    protected $status;

    public function __construct($product, $status)
    {
        $this->product = $product;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Product Status Notification')
                    ->markdown('emails.product_status')
                    ->with([
                        'product' => $this->product,
                        'status' => $this->status,
                    ]);
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Product Status Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
