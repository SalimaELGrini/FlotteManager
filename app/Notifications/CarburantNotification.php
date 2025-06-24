<?php

namespace App\Notifications;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class CarburantNotification extends Notification
{
    use Queueable;

    protected $message;

        public function __construct($message)
    {
        $this->message = $message;
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'time' => now()->diffForHumans(),
            'uuid' => (string) Str::uuid(), // 3tina UUID dyal notification
        ];
    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
