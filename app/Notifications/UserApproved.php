<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UserApproved extends Notification
{
    use Queueable;

    public $approvedBy;

    public function __construct($approvedBy)
    {
        $this->approvedBy = $approvedBy;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Votre compte a été approuvé par l'administrateur : " . $this->approvedBy,
        ];
    }
}
