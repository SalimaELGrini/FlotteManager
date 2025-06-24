<?php
namespace App\Services\FuelConsumptions;

use App\Repositories\FuelConsumption\FuelConsumptionRepositoryInterface;
use App\Models\User;
use App\Notifications\CarburantNotification;
use App\Models\Setting;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use App\Models\FuelConsumption;
class FuelConsumptionService
{
    protected $fuelRepo;

    public function __construct(FuelConsumptionRepositoryInterface $fuelRepo)
    {
        $this->fuelRepo = $fuelRepo;
    }

    public function getAll(array $filters, int $perPage = 10)
    {
        return $this->fuelRepo->paginateWithFilters($filters, $perPage);
    }

    public function find(int $id)
    {
        return $this->fuelRepo->find($id);
    }

    public function create(array $data)
    {
        $fuel = $this->fuelRepo->create($data);

        $this->notifyNewConsumption($fuel);

        $this->checkAbnormalConsumption($fuel);

        return $fuel;
    }

    public function update(int $id, array $data): bool
    {
        $updated = $this->fuelRepo->update($id, $data);

        if ($updated) {
            $fuel = $this->fuelRepo->find($id);
            $this->notifyUpdateConsumption($fuel);
        }

        return $updated;
    }

    public function delete(int $id): bool
    {
        return $this->fuelRepo->delete($id);
    }
    public function exportPDF($id)
{
    $fuelConsumption = FuelConsumption::with('vehicule')->findOrFail($id);

    $locale = app()->getLocale();
    App::setLocale($locale);

    $html = View::make('pages.fuel_consumption.fuel_pdf', compact('fuelConsumption', 'locale'))->render();

    $pdfPath = storage_path("app/public/fuel_{$id}.pdf");

    // Ensure directory exists
    if (!file_exists(storage_path("app/public"))) {
        mkdir(storage_path("app/public"), 0777, true);
    }

    ini_set('max_execution_time', 120);

    Browsershot::html($html)
        ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe')
        ->format('A4')
        ->margins(5, 5, 5, 5)
        ->timeout(90)
        ->save($pdfPath);

    // Verify if file exists
    if (!file_exists($pdfPath)) {
        throw new \Exception("Le fichier PDF n’a pas été créé à l’emplacement suivant: $pdfPath");
    }

    return $pdfPath;
}

    protected function notifyNewConsumption($fuel)
    {
        if (Setting::get('notifications_enabled') === 'true') {
            $message = " Nouvelle consommation enregistrée pour le véhicule [" . $fuel->vehicule->matricule . "].";

            if (auth()->id() != 1) {
                $superadmin = User::find(1);
                $superadmin->notify(new CarburantNotification($message));
            } else {
                $admins = User::where('id', '!=', 1)->get();
                Notification::send($admins, new CarburantNotification($message));
            }
        }
    }

    protected function notifyUpdateConsumption($fuel)
    {
        if (Setting::get('notifications_enabled') === 'true') {
            $message = " La consommation du véhicule [" . $fuel->vehicule->matricule . "] a été mise à jour.";

            if (auth()->id() != 1) {
                $superadmin = User::find(1);
                $superadmin->notify(new CarburantNotification($message));
            } else {
                $admins = User::where('id', '!=', 1)->get();
                Notification::send($admins, new CarburantNotification($message));
            }
        }
    }

    protected function checkAbnormalConsumption($fuel)
    {
        if ($fuel->distance_parcourue > 0) {
            $consommation_moyenne = $fuel->fuel_added / $fuel->distance_parcourue * 100;
            if ($consommation_moyenne > 15 && Setting::get('notifications_enabled') === 'true') {
                $alertMsg = " Le véhicule [{$fuel->vehicule->matricule}] a consommé une quantité anormale de carburant ce mois-ci. Consommation : {$consommation_moyenne} L/100km.";

                if (auth()->id() != 1) {
                    $superadmin = User::find(1);
                    $superadmin->notify(new CarburantNotification($alertMsg));
                } else {
                    $admins = User::where('id', '!=', 1)->get();
                    Notification::send($admins, new CarburantNotification($alertMsg));
                }
            }
        }
    }
}

