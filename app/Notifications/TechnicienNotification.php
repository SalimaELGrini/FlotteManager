<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TechnicienNotification extends Notification
{
    protected $technicien;
    protected $vehicule;
    protected $message;

    // Constructor to accept the message, technicien, and vehicule
    public function __construct($technicien, $vehicule, $message)
    {
        $this->technicien = $technicien;
        $this->vehicule = $vehicule;
        $this->message = $message;
    }

    // Specify where the notification will be sent (here, it's the database)
    public function via($notifiable)
    {
        return ['database'];  
    }

    // Return the data to be stored in the database
    public function toDatabase($notifiable)
    {
        return [
            'technicien_id' => $this->technicien->id, 
            'vehicule_id' => $this->vehicule->id, 
            'message' => $this->message, // Le message de la notification
            'created_at' => now(), 
        ];
    }
}
