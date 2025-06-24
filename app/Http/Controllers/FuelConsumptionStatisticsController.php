<?php

namespace App\Http\Controllers;

use App\Models\FuelConsumption;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FuelConsumptionStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $monthlyStats = DB::table('fuel_consumptions')
        ->join('vehicules', 'fuel_consumptions.vehicule_id', '=', 'vehicules.id')
        ->selectRaw('
            MONTH(date_fuel_added) as month,
            vehicules.matricule as vehicule_matricule,
            SUM(fuel_added) as total_fuel_added,
            SUM(distance_parcourue) as total_distance_parcourue
        ')
        ->groupBy('month', 'vehicules.matricule')
        ->orderBy('month')
        ->get();





        // Autres statistiques
        $totalFuelAdded = FuelConsumption::sum('fuel_added');
        $totalDistance = FuelConsumption::sum('distance_parcourue');
        $totalCost = FuelConsumption::sum('total_cost');
        $averageFuelEfficiency = FuelConsumption::avg('fuel_efficiency');

        $vehiclesWithMoreThanFive = Vehicule::withCount('fuelConsumptions')
        ->having('fuel_consumptions_count', '>', 5)
        ->get();

        $vehiclesWithPoorMonthlyConsumption = Vehicule::select(
            'vehicules.matricule',
            DB::raw('MONTH(fuel_consumptions.created_at) as month'),
            DB::raw('YEAR(fuel_consumptions.created_at) as year'),
            DB::raw('SUM(fuel_consumptions.fuel_added) as total_fuel_consumed')
        )
        ->join('fuel_consumptions', 'vehicules.id', '=', 'fuel_consumptions.vehicule_id')
        ->groupBy('vehicules.matricule', DB::raw('MONTH(fuel_consumptions.created_at)'), DB::raw('YEAR(fuel_consumptions.created_at)'))
        ->havingRaw('SUM(fuel_consumptions.fuel_added) > ?', [50]) 
        ->get();
        

        return view('statistics.fuel_consumption', compact(
            'monthlyStats',
            'totalFuelAdded',
            'totalDistance',
            'totalCost',
            'averageFuelEfficiency',
            'vehiclesWithMoreThanFive',
            'vehiclesWithPoorMonthlyConsumption',
            'month',
            'year'
        ));
    }
}