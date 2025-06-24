<?php

namespace App\Services\Pannes;

use App\Repositories\Pannes\PanneRepositoryInterface;
use App\Models\User;
use App\Notifications\PanneNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
class PanneService
{
    private PanneRepositoryInterface $panneRepo;

    public function __construct(PanneRepositoryInterface $panneRepo)
    {
        $this->panneRepo = $panneRepo;
    }

    public function getPannesWithFilters($request): array
    {
        $vehicules = $this->panneRepo->getAllVehicules();
        $garages = $this->panneRepo->getAllGarages();
        $typeInterventions = $this->panneRepo->getTypeInterventionsByName('Réparation');

        $pannes = $this->panneRepo->getPannesWithFilters($request);

        return compact('pannes', 'vehicules', 'garages', 'typeInterventions');
    }

    public function getDataForCreate(): array
    {
        $vehicules = $this->panneRepo->getAllVehicules();
        $drivers = $this->panneRepo->getAllDrivers();

        return compact('vehicules', 'drivers');
    }

    public function createPanne(array $data)
    {
        // resolved checkbox handling
        $data['resolved'] = $data['resolved'] ?? false;

        $panne = $this->panneRepo->create($data);

        $this->sendNotifications($panne);

        return $panne;
    }

    public function getPanneDetails($id)
    {
        return $this->panneRepo->findWithRelations($id);
    }

    private function sendNotifications($panne): void
    {
        $date_panne = Carbon::parse($panne->date_panne);
        $jours_en_panne = $date_panne->diffInDays(Carbon::now());
        $user = auth()->user();

        if ($user->role === 'user') {
            $superadmins = User::where('role', 'admin')->get();
            foreach ($superadmins as $superadmin) {
                $url = route('pannes.show', $panne->id);
                $superadmin->notify(new PanneNotification(" Un véhicule est en panne depuis $jours_en_panne jours (créé par un user).", $url));
            }
        } elseif ($user->role === 'admin') {
            $admins = User::where('role', 'user')->get();
            foreach ($admins as $admin) {
                $url = route('pannes.show', $panne->id);
                $admin->notify(new PanneNotification(" Un véhicule est en panne depuis $jours_en_panne jours (créé par le admin).", $url));
            }
        }

        // Notifications génériques
        $matricule = $panne->vehicule->numero ?? "Inconnu";
        $heures_en_intervention = 24;
        $maintenance_periodique = true;

        $notifiables = ($user->role === 'admin')
            ? User::where('role', 'user')->get()
            : User::where('role', 'admin')->get();

        foreach ($notifiables as $notifiable) {
            $notifiable->notify(new PanneNotification(" Intervention en cours sur le véhicule [$matricule] depuis plus de $heures_en_intervention heures."));

            if ($maintenance_periodique) {
                $notifiable->notify(new PanneNotification(" Le véhicule [$matricule] nécessite une maintenance périodique."));
            }
        }
    }

    public function getPanneWithRelations(int $id): array
    {
        $panne = $this->panneRepo->findById($id);

        if (!$panne) {
            abort(404, 'Panne non trouvée.');
        }

        $vehicules = \App\Models\Vehicule::all();
        $drivers = \App\Models\Driver::all();

        return compact('panne', 'vehicules', 'drivers');
    }

    public function updatePanne(int $id, array $data): void
    {
        $panne = $this->panneRepo->findById($id);
        if (!$panne) {
            abort(404, 'Panne non trouvée.');
        }

        $this->panneRepo->update($panne, $data);

        $this->notifyUsers($panne);
    }

    protected function notifyUsers($panne): void
    {
        $user = auth()->user();
        $matricule = $panne->vehicule->numero ?? "Inconnu";
        $message = '';

        $destinataires = collect();

        if ($user->role === 'user') {
            $destinataires = User::where('role', 'admin')->get();
            $message = " Un user a modifié la panne du véhicule [$matricule].";
        } elseif ($user->role === 'admin') {
            $destinataires = User::where('role', 'user')->get();
            $message = " Le admin a modifié la panne du véhicule [$matricule].";
        }

        foreach ($destinataires as $notifiable) {
            $notifiable->notify(new PanneNotification($message));
        }
    }

    public function deletePanne(int $id): bool
    {
        return $this->panneRepo->deleteById($id);
    }

    public function searchPannes(string $vehiculeNumero)
    {
        return $this->panneRepo->searchByVehiculeNumero($vehiculeNumero);
    }

    public function createIntervention(array $data, $user)
    {
        $intervention = $this->panneRepo->createIntervention($data);

        $matricule = $intervention->vehicule->numero ?? 'Inconnu';

        $destinataires = ($user->role === 'admin')
            ? User::where('role', 'user')->get()
            : User::where('role', 'admin')->get();

        foreach ($destinataires as $notifiable) {
            $notifiable->notify(new PanneNotification("Nouvelle intervention ajoutée pour le véhicule [$matricule]."));
        }

        return $intervention;
    }

    public function exportPannePDF(int $id)
    {
        $panne = $this->panneRepo->findPanneWithRelations($id);

        $locale = app()->getLocale();
        App::setLocale($locale);

        $html = View::make('pages.pannes.panne-details', compact('panne', 'locale'))->render();

        $pdfPath = storage_path("app/public/panne_{$id}.pdf");

        ini_set('max_execution_time', 120);

        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe')
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(90)
            ->save($pdfPath);

        return $pdfPath;
    }
}

