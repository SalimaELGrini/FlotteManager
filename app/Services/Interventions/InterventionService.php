<?php

namespace App\Services\Interventions;
use App\Repositories\Interventions\InterventionRepositoryInterface;
use App\Models\{Panne, TypeIntervention, Vehicule, User, Garage, Setting};
use App\Notifications\{TechnicienNotification, PanneNotification};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InterventionService
{
    protected $interventionRepository;

    public function __construct(InterventionRepositoryInterface $interventionRepository)
    {
        $this->interventionRepository = $interventionRepository;
    }

    public function handleIndex(Request $request)
    {
        $interventions = $this->interventionRepository->getFilteredInterventions($request->all());
        $filters = $this->interventionRepository->getFilterOptions();

        return view('pages.interventions.index', array_merge([
            'interventions' => $interventions
        ], $filters));
    }

    public function handleCreate(Request $request)
    {
        if (Gate::denies('createIntervention')) {
            abort(403, 'Vous n\'êtes pas autorisé à créer une intervention.');
        }

        $vehicule = $request->has('vehicule_id') ? Vehicule::find($request->vehicule_id) : null;

        $vehicules = Vehicule::groupBy('modele')->selectRaw('MIN(id) as id, modele')->get();
        $pannes = Panne::groupBy('resolved')->selectRaw('MIN(id) as id, resolved')->get();
        $garages = Garage::groupBy('name')->selectRaw('MIN(id) as id, name')->get();
        $typesInterventions = TypeIntervention::groupBy('name')->selectRaw('MIN(id) as id, name')->get();

        return view('pages.interventions.create', compact(
            'vehicule', 'vehicules', 'pannes', 'garages', 'typesInterventions'
        ));
    }

    public function store(array $data)
    {
        $intervention = $this->interventionRepository->create($data);

        if (!empty($data['panne_id'])) {
            $panne = Panne::findOrFail($data['panne_id']);
            $panne->resolved = true;
            $panne->save();
        }

        $vehicule = Vehicule::find($data['vehicule_id']);
        $type = TypeIntervention::find($data['type_intervention_id']);

        $technicien = $this->interventionRepository->findByTechnician($data['nom_technician']);

        if ($technicien) {
            $interventions_count = $this->interventionRepository->countTechnicianMonthly($data['nom_technician']);
            $quota_max = 10;
            $messageFin = " Le technicien {$data['nom_technician']} vient de terminer une intervention sur le véhicule {$vehicule->matricule}.";
            $messageQuota = " Le technicien {$data['nom_technician']} a dépassé son quota d’interventions ce mois-ci.";

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

        if ($type && $type->name === 'Reparation') {
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
                $user->notify(new PanneNotification(" Le véhicule [{$vehicule->matricule}] a été réparé avec succès."));
                if ($data['total_cost'] > 5000) {
                    $user->notify(new PanneNotification(" Le coût de réparation du véhicule [{$vehicule->matricule}] dépasse le budget estimé."));
                }
            }
        }
    }

    public function update(array $data, int $id)
    {
        return $this->interventionRepository->update($data, $id);
    }

    public function ajaxStore(array $data)
    {
        return $this->interventionRepository->ajaxStore($data);
    }

    public function findByIdWithRelations($id)
    {
        return $this->interventionRepository->findByIdWithRelations($id);
    }

    public function findById($id)
    {
        return $this->interventionRepository->findById($id);
    }

    public function getVehiculesGrouped()
    {
        return $this->interventionRepository->getVehiculesGrouped();
    }

    public function getPannesGrouped()
    {
        return $this->interventionRepository->getPannesGrouped();
    }

    public function getGaragesGrouped()
    {
        return $this->interventionRepository->getGaragesGrouped();
    }

    public function getTypesInterventionsGrouped()
    {
        return $this->interventionRepository->getTypesInterventionsGrouped();
    }

    public function delete($id)
    {
        return $this->interventionRepository->delete($id);
    }

    public function generateSinglePdf($id)
    {
        $intervention = $this->interventionRepository
            ->getInterventionWithRelations($id, ['vehicule']);

        // Multilangue
        $locale = app()->getLocale();
        App::setLocale($locale);

        // Render la vue
        $html = View::make('pages.interventions.intervention_single', compact('intervention', 'locale'))->render();

        // Chemin du PDF
        $pdfPath = storage_path('app/public/intervention_' . $intervention->id . '.pdf');

        // Timeout
        ini_set('max_execution_time', 120);

        // Génération PDF avec Browsershot
        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe') // Change selon ton navigateur
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(180)
            ->addChromiumArguments([
                '--no-sandbox',
                '--disable-setuid-sandbox'
            ])
            ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

}
