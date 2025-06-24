<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Panne;
use App\Models\Driver;
use App\Models\Intervention;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PanneStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        
        $totalPannes = Panne::where('resolved', false)->count();
        $totalInterventions = Intervention::whereHas('panne')->count();
        $totalCosts = Intervention::whereHas('panne')->sum('total_cost');

        $pannesByMonth = Panne::selectRaw('MONTH(date_panne) as month, COUNT(*) as total_pannes')
            ->whereYear('date_panne', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        
        $interventionsByMonth = Intervention::selectRaw('MONTH(date_intervention) as month, COUNT(*) as total_interventions')
            ->whereYear('date_intervention', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        
        $totalCostsByMonth = Intervention::selectRaw('MONTH(date_intervention) as month, SUM(total_cost) as total_cost')
            ->whereYear('date_intervention', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        
        $frequentPannesVehicles = Vehicule::withCount('pannes')
            ->having('pannes_count', '>', 5)
            ->get();

        
        $commonPanneDescriptions = Panne::selectRaw('description, COUNT(*) as count')
            ->groupBy('description')
            ->having('count', '>', 5)
            ->orderByDesc('count')
            ->get();

        
        $driversWithActivePannes = Driver::whereHas('vehicules.pannes', function ($query) {
                $query->where('status', 'en_cours');
            })
            ->with(['vehicules.pannes' => function ($query) {
                $query->where('status', 'en_cours');
            }])
            ->get();

        
        $pannesByDriver = Panne::leftJoin('drivers', 'pannes.driver_id', '=', 'drivers.id')
            ->selectRaw('COALESCE(drivers.nom, "Inconnu") as driver_name, COUNT(pannes.id) as total_pannes')
            ->where('pannes.status', 'en_cours')
            ->groupBy('drivers.nom')
            ->get();

        return view('statistics.pannes', compact(
            'pannesByMonth',
            'interventionsByMonth',
            'totalCostsByMonth',
            'frequentPannesVehicles',
            'commonPanneDescriptions',
            'driversWithActivePannes',
            'totalPannes',
            'totalInterventions',
            'totalCosts',
            'pannesByDriver'
        ));
    }
    public function statistiques(Request $request)
{
    $year = $request->input('year', Carbon::now()->year);
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Panne::query();

    if ($startDate && $endDate) {
        $query->whereBetween('date_panne', [$startDate, $endDate]);
    } else {
        $query->whereYear('date_panne', $year);
    }

    $totalPannes = $query->count();
    $totalInterventions = $query->whereHas('interventions')->count();
    $totalCosts = $query->sum('cost');

    return view('statistiques.pannes', compact('totalPannes', 'totalInterventions', 'totalCosts'));
}

}