<?php
namespace App\Services\Vehicules;

use App\Repositories\Vehicules\VehiculeRepositoryInterface;
use App\Http\Requests\Vehicules\UpdateVehiculeRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VehicleNotification;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\App;




class VehiculeService
{
    protected $vehiculeRepository;

    public function __construct(VehiculeRepositoryInterface $vehiculeRepository)
    {
        $this->vehiculeRepository = $vehiculeRepository;
    }

    public function getVehiculesList(Request $request)
    {
        $vehiculesQuery = $this->vehiculeRepository->query();
        $warnings = [];

        $vehicles = $vehiculesQuery->get();

        foreach ($vehicles as $vehicle) {
            $lastVisitDate = Carbon::parse($vehicle->date_visite_technique);
            $expiryDate = $lastVisitDate->addYear();
            $now = Carbon::now();
            $diffInMonths = $now->diffInMonths($expiryDate);

            if ($diffInMonths == 3) {
                $warnings[] = "Le véhicule {$vehicle->name} doit renouveler son contrôle technique dans 3 mois !";
            } elseif ($diffInMonths == 1) {
                $warnings[] = "Le véhicule {$vehicle->name} doit renouveler son contrôle technique dans 1 mois !";
            } elseif ($diffInMonths == 0 && $now->greaterThanOrEqualTo($expiryDate)) {
                $warnings[] = "Le véhicule {$vehicle->name} a expiré son contrôle technique !";
            }
        }

        $vehiculesQuery = $this->vehiculeRepository->applyFilters($vehiculesQuery, $request);
        $vehicules = $vehiculesQuery->paginate(10)->appends($request->query());

        $years = DB::table('vehicules')->distinct()->pluck(DB::raw('year(created_at) as year'));
        $drivers = Driver::all();

        return view('pages.vehicules.index', compact('vehicules', 'years', 'drivers'));
    }

    public function searchVehicule(Request $request)
    {
        $vehicule = $this->vehiculeRepository->find($request->vehicule_id);

        if (!$vehicule) {
            return redirect()->route('vehicules.index')->with('error', 'Véhicule non trouvé.');
        }

        $query = $this->vehiculeRepository->whereId($vehicule->id);
        $query = $this->vehiculeRepository->applyFilters($query, $request);

        $assignments = $query->paginate(10);

        return view('pages.vehicules.assignmentsdetails', compact('assignments', 'vehicule'));
    }

    public function createVehicule(array $data): Vehicule
    {
        $vehicule = $this->vehiculeRepository->create($data);

        if (isset($data['driver_id'])) {
            $vehicule->drivers()->attach($data['driver_id'], ['assigned_at' => now()]);
        }

        $user = auth()->user();

        if ($user->role === 'user') {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new VehicleNotification($vehicule, "Véhicule ajouté par un utilisateur : {$vehicule->matricule}"));
        } elseif ($user->role === 'admin') {
            $users = User::where('role', 'user')->get();
            Notification::send($users, new VehicleNotification($vehicule, "Nouveau véhicule ajouté par un admin : {$vehicule->matricule}"));
        }

        return $vehicule;
    }

    public function getVehiculeById(int $id): Vehicule
    {
        return $this->vehiculeRepository->findById($id);
    }

    public function getVehiculeWithDrivers(int $id): Vehicule
    {
        return $this->vehiculeRepository->findWithDriversById($id);
    }
    public function updateVehicule(UpdateVehiculeRequest $request, Vehicule $vehicule): void
    {
        $this->vehiculeRepository->update($vehicule, $request->validated());

        if ($request->has('driver_id')) {
            $vehicule->drivers()->sync([]); // Clear old
            foreach ($request->driver_id as $driverId) {
                $vehicule->drivers()->attach($driverId, ['assigned_at' => now()]);
            }
        }

        if (auth()->user()->role === 'admin') {
            $admins = User::where('role', 'user')->get();
            Notification::send($admins, new VehicleNotification($vehicule, "Véhicule modifié : {$vehicule->matricule}"));
        }
    }

    public function deleteVehicule(Vehicule $vehicule): void
    {
        $this->vehiculeRepository->delete($vehicule);
    }

public function reassignDrivers(int $vehiculeId, array $driverIds): void
{
    $this->vehiculeRepository->detachDrivers($vehiculeId);
    $this->vehiculeRepository->attachDrivers($vehiculeId, $driverIds);
}
public function generateVehiculePdf(int $vehiculeId): string
{
    $locale = App::getLocale();
    App::setLocale($locale);

    $vehicule = $this->vehiculeRepository->findWithDetails($vehiculeId);

    $html = View::make('pages.vehicules.vehicule_single', compact('vehicule', 'locale'))->render();

    $pdfPath = storage_path('app/public/vehicule_' . $vehicule->id . '.pdf');

    ini_set('max_execution_time', 120);

    Browsershot::html($html)
        ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe')
        ->format('A4')
        ->margins(5, 5, 5, 5)
        ->timeout(300)
        ->save($pdfPath);

    return $pdfPath;
}
}
