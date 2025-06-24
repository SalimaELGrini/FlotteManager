<?php
namespace App\Notifications;

use App\Models\Intervention;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewInterventionNotification extends Notification
{
    use Queueable;

    public $intervention;
    public $user;

    public function __construct(Intervention $intervention, $user)
    {
        $this->intervention = $intervention;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Nouvelle intervention créée sur le véhicule [{$this->intervention->vehicule->matricule}] par {$this->user->name}.",
            'url' => null,
        ];
    }
}

