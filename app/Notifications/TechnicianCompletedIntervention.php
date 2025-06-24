<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TechnicianCompletedIntervention extends Notification
{
    use Queueable;

    public $technician;
    public $vehicle;

    public function __construct($technician, $vehicle)
    {
        $this->technician = $technician;
        $this->vehicle = $vehicle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => " Le technicien {$this->technician} vient de terminer une intervention sur le véhicule {$this->vehicle}."
        ];
    }
}
