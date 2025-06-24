<?php
namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\intervention;
use App\Models\fuelConsumption;
use Illuminate\Http\Request;

class VehicleStatisticsController extends Controller
{
    public function index (Request $request)
    {
        $month = $request->input('month', date('m')); // Default to current month
        $year = $request->input('year', date('Y')); // Default to current year

        // Get fuel efficiency per vehicle
        $vehiclesFuelEfficiency = Vehicule::whereMonth('date_achat', $month)
            ->whereYear('date_achat', $year)
            ->get()
            ->map(function ($vehicle) use ($month, $year) {
                return [
                    'vehicle' => $vehicle->numero,
                    'average_fuel_efficiency' => $vehicle->fuelConsumptions()
                        ->whereMonth('date_fuel_added', $month)
                        ->whereYear('date_fuel_added', $year)
                        ->avg('fuel_efficiency'),
                ];
            });

        // Get vehicles with high costs
        $vehiclesWithHighCosts = Vehicule::getTotalCostPerVehicleByMonth($month, $year)
            ->sortByDesc('total_cost') // Sort by total cost in descending order
            ->take(5); // Top 5 vehicles

        // Get vehicles close to technical visit expiration
        $vehiclesCloseToVisit = Vehicule::getVehiclesCloseToTechVisit();

        // Get vehicles with more than 5 pannes
        $vehiclesWithMoreThanFivePannes = Vehicule::getVehiclesWithMoreThanFivePannes($month, $year);
// Get vehicles with good performance (low costs or high fuel efficiency)
$vehiclesWithGoodPerformance = Vehicule::whereMonth('date_achat', $month)
    ->whereYear('date_achat', $year)
    ->get()
    ->filter(function ($vehicle) {
        // Filtering based on performance criteria (e.g., low cost or high fuel efficiency)
        return $vehicle->fuelConsumptions()->avg('fuel_efficiency') > 10 && $vehicle->cost < 1000; // Example criteria
    });

// Get vehicles with bad performance (high costs or low fuel efficiency)
$vehiclesWithBadPerformance = Vehicule::whereMonth('date_achat', $month)
    ->whereYear('date_achat', $year)
    ->get()
    ->filter(function ($vehicle) {
        // Filtering based on performance criteria (e.g., high cost or low fuel efficiency)
        return $vehicle->fuelConsumptions()->avg('fuel_efficiency') < 5 || $vehicle->cost > 5000; // Example criteria
    });

        return view('statistics.vehicule', compact(
            'vehiclesFuelEfficiency',
            'vehiclesWithHighCosts',
            'vehiclesCloseToVisit',
            'vehiclesWithMoreThanFivePannes',
            'month',
            'year','vehiclesWithGoodPerformance','vehiclesWithBadPerformance'
        ));
    }
}