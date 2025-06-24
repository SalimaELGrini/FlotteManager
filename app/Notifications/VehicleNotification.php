<?php

namespace App\Notifications;

use App\Models\Vehicule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VehicleNotification extends Notification
{
    use Queueable;

    public $vehicule;
    public $message;

    public function __construct(Vehicule $vehicule, $message)
    {
        $this->vehicule = $vehicule;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'vehicule_id' => $this->vehicule->id,
            'matricule' => $this->vehicule->matricule,
            'message' => $this->message,
        ];
    }
}
