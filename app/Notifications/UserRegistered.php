<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UserRegistered extends Notification
{
    use Queueable;

    public $newUser;

    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function via($notifiable)
    {
        return ['database']; // Ghadi ytsajel f base de données
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Un nouvel utilisateur s\'est inscrit: ' . $this->newUser->username . ' (Rôle: ' . $this->newUser->role . ')',
            'user_id' => $this->newUser->id,
            'role' => $this->newUser->role,
        ];
    }
}

