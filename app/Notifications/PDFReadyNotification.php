<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PDFReadyNotification extends Notification
{
    public $pdfPath;

    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'PDF généré avec succès',
            'message' => 'Votre PDF de consommation carburant est prêt.',
            'url' => url(asset($this->pdfPath)),
        ];
    }
}
