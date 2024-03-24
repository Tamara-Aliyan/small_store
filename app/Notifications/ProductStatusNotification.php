<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\API\V1\Product;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductStatusNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $status;

    public function __construct(Product $product, $status)
    {
        $this->product = $product;
        $this->status = $status;
    }
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->status == 'approved' ? 'approved' : 'rejected';
        return (new MailMessage)
                    ->line("Your product '{$this->product->name}' has been {$statusText}.")
                    ->action('View Product', url('/products/' . $this->product->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
