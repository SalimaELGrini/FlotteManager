<?php
namespace App\Jobs;

use App\Models\FuelConsumption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\PDFReadyNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ExportFuelConsumptionPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fuelConsumptionId, $user;

    public function __construct($fuelConsumptionId, $user)
    {
        $this->fuelConsumptionId = $fuelConsumptionId;
        $this->user = $user;
    }

    public function handle()
    {
        $fuelConsumption = FuelConsumption::with('vehicule')->findOrFail($this->fuelConsumptionId);

        App::setLocale($this->user->locale ?? 'fr');

        $html = View::make('pages.fuel_consumption.fuel_pdf', [
            'fuelConsumption' => $fuelConsumption,
            'locale' => App::getLocale()
        ])->render();

        $pdfPath = storage_path("app/public/fuel_{$this->fuelConsumptionId}.pdf");

        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe')
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(120)
            ->save($pdfPath);

        // Notifier l'utilisateur
        Notification::send($this->user, new PDFReadyNotification("storage/fuel_{$this->fuelConsumptionId}.pdf"));
    }
}
