<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TechnicianQuotaExceeded extends Notification
{
    use Queueable;

    public $technician;

    public function __construct($technician)
    {
        $this->technician = $technician;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => " Le technicien {$this->technician} a dépassé son quota d’interventions ce mois-ci."
        ];
    }
}
