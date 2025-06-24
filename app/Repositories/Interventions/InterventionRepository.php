<?php

namespace App\Repositories\Interventions;

use App\Models\Intervention;
use App\Models\Vehicule;
use App\Models\TypeIntervention;
use App\Models\Garage;
use App\Models\Piece;
use Carbon\Carbon;
use App\Models\Panne;
use App\Models\User;
use App\Models\Setting;
use App\Notifications\PanneNotification;
use App\Notifications\TechnicienNotification;
use Illuminate\Support\Facades\Gate;

class InterventionRepository implements InterventionRepositoryInterface
{
    public function getFilteredInterventions($filters)
    {
        $query = Intervention::with(['vehicule', 'typeIntervention', 'panne', 'garage', 'pieces']);

        if (!empty($filters['modele']) && $filters['modele'] !== 'all') {
            $query->whereHas('vehicule', function ($q) use ($filters) {
                $q->where('modele', $filters['modele']);
            });
        }

        if (!empty($filters['type_name']) && $filters['type_name'] !== 'all') {
            $query->whereHas('typeIntervention', function ($q) use ($filters) {
                $q->where('name', $filters['type_name']);
            });
        }

        if (!empty($filters['date_range']) && $filters['date_range'] !== 'all') {
            switch ($filters['date_range']) {
                case 'today':
                    $query->whereDate('date_intervention', today());
                    break;
                case 'yesterday':
                    $query->whereDate('date_intervention', today()->subDay());
                    break;
                case 'last_2_days':
                    $query->whereDate('date_intervention', '>=', today()->subDays(2));
                    break;
                case 'last_3_days':
                    $query->whereDate('date_intervention', '>=', today()->subDays(3));
                    break;
                case 'last_7_days':
                    $query->whereDate('date_intervention', '>=', today()->subDays(7));
                    break;
                case 'last_month':
                    $query->whereMonth('date_intervention', now()->subMonth()->month)
                          ->whereYear('date_intervention', now()->subMonth()->year);
                    break;
                case 'last_2months':
                    $query->whereMonth('date_intervention', now()->subMonths(2)->month)
                          ->whereYear('date_intervention', now()->subMonths(2)->year);
                    break;
                case 'last_year':
                    $query->whereYear('date_intervention', now()->subYear()->year);
                    break;
            }
        }

        return $query->paginate(10);
    }

    public function getFilterOptions()
    {
        return [
            'vehicules' => Vehicule::select('modele')->distinct()->get(),
            'typesInterventions' => TypeIntervention::select('name')->distinct()->get(),
            'pieces' => Piece::all(),
            'garages' => Garage::all(),
        ];
    }
    public function create(array $data)
    {
        return Intervention::create($data);
    }

    public function findByTechnician(string $name)
    {
        return Intervention::where('nom_technician', $name)->first();
    }

    public function countTechnicianMonthly(string $name): int
    {
        return Intervention::where('nom_technician', $name)
            ->whereMonth('date_intervention', Carbon::now()->month)
            ->count();
    }

    public function update(array $data, int $id)
    {
        $intervention = Intervention::findOrFail($id);

        if (Gate::denies('editIntervention', $intervention)) {
            abort(403, 'Vous n\'êtes pas autorisé à mettre à jour cette intervention.');
        }

        $intervention->update([
            'vehicule_id' => $data['vehicule_id'],
            'type_intervention_id' => $data['type_intervention_id'],
            'date_intervention' => $data['date_intervention'],
            'duration' => $data['duration'],
            'description' => $data['description'],
            'parts_used' => $data['parts_used'] ?? null,
            'total_cost' => $data['total_cost'],
            'nom_technician' => $data['nom_technician'],
            'garage_id' => $data['garage_id'],
            'panne_id' => $data['panne_id'] ?? null,
        ]);

        if (!empty($data['panne_id'])) {
            $panne = Panne::findOrFail($data['panne_id']);
            $panne->resolved = true;
            $panne->save();
        }

        $vehicule = Vehicule::find($data['vehicule_id']);
        $type = TypeIntervention::find($data['type_intervention_id']);
        $technicien = Intervention::where('nom_technician', $data['nom_technician'])->first();

        if ($technicien) {
            $interventions_count = Intervention::where('nom_technician', $data['nom_technician'])
                ->whereMonth('date_intervention', Carbon::now()->month)
                ->count();

            $quota_max = 10;
            $messageFin = " Le technicien {$technicien->nom_technician} a modifié une intervention sur le véhicule {$vehicule->matricule}.";
            $messageQuota = " Le technicien {$technicien->nom_technician} a dépassé son quota d’interventions ce mois-ci.";

            if (Setting::get('notifications_enabled') === 'true') {
                $currentUser = auth()->user();

                if ($currentUser->id == 1) {
                    $admins = User::where('role', 'user')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new TechnicienNotification($technicien, $vehicule, $messageFin));
                        if ($interventions_count > $quota_max) {
                            $admin->notify(new TechnicienNotification($technicien, $vehicule, $messageQuota));
                        }
                    }
                } else {
                    $superadmin = User::find(1);
                    if ($superadmin && $superadmin->id !== $currentUser->id) {
                        $superadmin->notify(new TechnicienNotification($technicien, $vehicule, $messageFin));
                        if ($interventions_count > $quota_max) {
                            $superadmin->notify(new TechnicienNotification($technicien, $vehicule, $messageQuota));
                        }
                    }
                }
            }
        }

        if ($type->name === 'Reparation') {
            $currentUser = auth()->user();
            $notifRecipients = [];

            if ($currentUser->id == 1) {
                $notifRecipients = User::where('role', 'user')->get();
            } else {
                $superadmin = User::find(1);
                if ($superadmin && $superadmin->id !== $currentUser->id) {
                    $notifRecipients = collect([$superadmin]);
                }
            }

            foreach ($notifRecipients as $user) {
                $user->notify(new PanneNotification(" Le véhicule [{$vehicule->matricule}] a subi une mise à jour de réparation."));

                if ($data['total_cost'] > 5000) {
                    $user->notify(new PanneNotification(" Le coût de réparation du véhicule [{$vehicule->matricule}] dépasse le budget estimé."));
                }
            }
        }

        return $intervention;
    }

    public function ajaxStore(array $data)
    {
        $intervention = new Intervention();
        $intervention->fill($data);
        $intervention->save();

        return $intervention;
    }

    public function findByIdWithRelations($id)
    {
        return Intervention::with(['vehicule', 'typeIntervention', 'panne', 'garage'])->findOrFail($id);
    }

    public function findById($id)
    {
        return Intervention::findOrFail($id);
    }

    public function getVehiculesGrouped()
    {
        return Vehicule::groupBy('modele')->selectRaw('MIN(id) as id, modele')->get();
    }

    public function getPannesGrouped()
    {
        return Panne::groupBy('resolved')->selectRaw('MIN(id) as id, resolved')->get();
    }

    public function getGaragesGrouped()
    {
        return Garage::groupBy('name')->selectRaw('MIN(id) as id, name')->get();
    }

    public function getTypesInterventionsGrouped()
    {
        return TypeIntervention::groupBy('name')->selectRaw('MIN(id) as id, name')->get();
    }

    public function delete($id)
    {
        $intervention = $this->findById($id);
        return $intervention->delete();
    }

        public function getInterventionWithRelations($id, array $relations = [])
    {
        return Intervention::with($relations)->findOrFail($id);
    }

}

