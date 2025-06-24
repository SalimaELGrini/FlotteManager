<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Panne;
use App\Models\FuelConsumption;
use App\Models\Intervention;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

use App\Notifications\UserApproved;
class AdminController extends Controller
{
      
    public function createUser(Request $request)
    {
        // Vérifie si l'utilisateur est autorisé à créer un utilisateur
        $this->authorize('createUser', User::class);

        // Si l'utilisateur est admin, code pour créer un nouvel utilisateur
        // Par exemple, tu peux créer un formulaire pour ajouter un utilisateur
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', // par défaut role user
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès!');
    }
    public function index()
    {
        //  
        $totalInterventions = Intervention::count();

        //    
        $interventionsByType = Intervention::join('type_interventions', 'interventions.type_intervention_id', '=', 'type_interventions.id')
            ->select('type_interventions.name as type', DB::raw('COUNT(interventions.id) as total'))
            ->groupBy('type_interventions.name')
            ->pluck('total', 'type')
            ->mapWithKeys(function ($value, $key) use ($totalInterventions) {
                $percentage = ($totalInterventions > 0) ? round(($value / $totalInterventions) * 100, 2) : 0;
                return [$key => $percentage];
            });
            $totalInterventions = Intervention::count();
            $interventionsByType = Intervention::join('type_interventions', 'interventions.type_intervention_id', '=', 'type_interventions.id')
            ->select('type_interventions.name as type', DB::raw('COUNT(interventions.id) as total'))
            ->groupBy('type_interventions.name')
            ->pluck('total', 'type')
            ->mapWithKeys(function ($value, $key) use ($totalInterventions) {
                $percentage = ($totalInterventions > 0) ? round(($value / $totalInterventions) * 100, 2) : 0;
                return [$key => $percentage];
            });

        // 
        $interventionsByMonth = Intervention::select(DB::raw("DATE_FORMAT(date_intervention, '%Y-%m') as month"), DB::raw('COUNT(id) as total'))
            ->groupBy('month')
            ->pluck('total', 'month');

        // 
        $costsByMonth = Intervention::select(DB::raw("DATE_FORMAT(date_intervention, '%Y-%m') as month"), DB::raw('SUM(total_cost) as total'))
            ->groupBy('month')
            ->pluck('total', 'month');

        //  
        $interventionsByVehicule = Intervention::join('vehicules', 'interventions.vehicule_id', '=', 'vehicules.id')
            ->select('vehicules.matricule as vehicule', DB::raw('COUNT(interventions.id) as total'))
            ->groupBy('vehicules.matricule')
            ->pluck('total', 'vehicule');

        //    
        $interventionsByTechnician = Intervention::select('nom_technician', DB::raw('COUNT(id) as total'))
            ->whereNotNull('nom_technician')
            ->groupBy('nom_technician')
            ->pluck('total', 'nom_technician');

        // 
        $averageTimeBetweenRepairs = DB::table('interventions as i1')
            ->select(DB::raw('AVG(diff_days) as avg_days'))
            ->fromSub(function ($query) {
                $query->select('i1.id', DB::raw('DATEDIFF(i1.date_intervention, i2.date_intervention) as diff_days'))
                    ->from('interventions as i1')
                    ->leftJoin('interventions as i2', function ($join) {
                        $join->on('i1.vehicule_id', '=', 'i2.vehicule_id')
                            ->on('i1.date_intervention', '>', 'i2.date_intervention');
                    })
                    ->whereNotNull('i2.date_intervention');
            }, 'subquery')
            ->value('avg_days') ?? 0;

        //   (Reliability Score)
        $reliabilityScore = Intervention::select(DB::raw('COUNT(id) / (SELECT COUNT(DISTINCT vehicule_id) FROM interventions) as score'))
            ->value('score') ?? 0;

            // Statistique des dépenses de carburant par mois
        $fuelCostsByMonth = DB::table('fuel_consumptions')
        ->select(DB::raw("DATE_FORMAT(date_fuel_added, '%Y-%m') as month"), DB::raw('SUM(total_cost) as total'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        // 
        $pannesCount = Panne::count();

          
        $fuelConsumptions = FuelConsumption::select(DB::raw('SUM(fuel_added) as total_fuel'))->first();
        $totalFuel = $fuelConsumptions->total_fuel;

        // 
        $pannesData = Panne::select(DB::raw('COUNT(*) as pannes_count, vehicule_id'))
            ->groupBy('vehicule_id')
            ->get();

        // 
        $chart = new Chart;
        $chart->labels($pannesData->pluck('vehicule_id')->toArray());
        $chart->dataset('Nombre de Pannes', 'bar', $pannesData->pluck('pannes_count')->toArray());

        // 
        $stats = compact(
            'totalInterventions', 'interventionsByType', 'interventionsByMonth',
            'costsByMonth', 'interventionsByVehicule', 'interventionsByTechnician',
            'averageTimeBetweenRepairs', 'reliabilityScore'
        );
        
      
        return view('pages.dashboard', compact(
            'pannesCount', 'totalFuel', 'chart', 'stats','fuelCostsByMonth',
            'interventionsByMonth', 'costsByMonth', 'interventionsByVehicule', 'interventionsByType'
        ));
       
        
    }
    public function statistics(Request $request) {
        $totalInterventions = Intervention::count();
        $interventionsByType = Intervention::join('type_interventions', 'interventions.type_intervention_id', '=', 'type_interventions.id')
        ->select('type_interventions.name as type', DB::raw('COUNT(interventions.id) as total'))
        ->groupBy('type_interventions.name')
        ->pluck('total', 'type')
        ->mapWithKeys(function ($value, $key) use ($totalInterventions) {
            $percentage = ($totalInterventions > 0) ? round(($value / $totalInterventions) * 100, 2) : 0;
            return [$key => $percentage];
        });

        $interventionsByTechnician = Intervention::select('nom_technician', DB::raw('COUNT(id) as total'))
        ->whereNotNull('nom_technician')
        ->groupBy('nom_technician')
        ->pluck('total', 'nom_technician');

        $averageTimeBetweenRepairs = DB::table(DB::raw("(SELECT i1.vehicule_id, DATEDIFF(i1.date_intervention, i2.date_intervention) as diff_days
        FROM interventions i1
        LEFT JOIN interventions i2 
        ON i1.vehicule_id = i2.vehicule_id 
        AND i1.date_intervention > i2.date_intervention
        WHERE i2.date_intervention IS NOT NULL) as subquery"))
        ->select('vehicule_id', DB::raw('AVG(diff_days) as avg_days'))
        ->groupBy('vehicule_id')
        ->pluck('avg_days', 'vehicule_id'); 



       

        return view('pages.statistics', compact('interventionsByType', 'interventionsByTechnician','averageTimeBetweenRepairs'));
    }
    public function pendingUsers()
    {
        $users = User::where('status', 'En attente')->get(); // uniquement li mazal makhdawch approve
    
        return view('pages.admin.pending.pending-users', compact('users'));
    }
    

    
    public function approuver(User $user)
    {
        $user->status = 'Approuvé';
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => "L'utilisateur {$user->username} a été approuvé avec succès."
        ]);
    }
    public function refuser(User $user)
    {
        $user->delete(); // Suppression directe

        return response()->json([
            'success' => true,
            'message' => "L'utilisateur a été supprimé (refusé) avec succès."
        ]);
    }

}