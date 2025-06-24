<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class PanneNotification extends Notification
{
    use Queueable;

    private $message;
    private $url;

    public function __construct($message, $url = null)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
            'uuid' => (string) Str::uuid(),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}




