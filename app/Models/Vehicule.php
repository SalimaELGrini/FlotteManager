<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'modele',
        'matricule',
        'annee_fabrication',
        'type_carburant',
        'capacite_reservoir',
        'kilometrage',
        'date_visite_technique',
        'date_expiration_assurance',
        'status',
        'date_achat',
    ];
    

    // Relation avec les conducteurs
    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'assignments')
                    ->withPivot('date_debut', 'date_fin', 'type_affectation', 'remarques');
    }
     
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Consommation de carburant
    public function fuelConsumptions()
    {
        return $this->hasMany(FuelConsumption::class);
    }

    public function getAverageConsumptionAttribute()
    {
        $totalFuel = $this->fuelConsumptions()->sum('fuel_added');
        $totalDistance = $this->fuelConsumptions()->sum('distance_parcourue');

        if ($totalFuel > 0 && $totalDistance > 0) {
            return round(($totalFuel / $totalDistance) * 100, 2);
        }

        return null;
    }
    // In Vehicule model (app/Models/Vehicule.php)

public function pannes()
{
    return $this->hasMany(Panne::class); // Assuming you have a Panne model
}
public static function getVehiclesWithMoreThanFivePannes($month, $year)
{
    return self::whereHas('pannes', function ($query) use ($month, $year) {
        $query->whereMonth('date_panne', $month)
              ->whereYear('date_panne', $year);
    })
    ->withCount(['pannes' => function ($query) use ($month, $year) {
        $query->whereMonth('date_panne', $month)
              ->whereYear('date_panne', $year);
    }])
    ->having('pannes_count', '>', 5)
    ->get();
}

    // Récupérer les véhicules en panne pour le mois
    public static function getVehiclesInPanneByMonth($month, $year)
    {
        return self::whereHas('pannes', function ($query) use ($month, $year) {
            $query->whereMonth('date_panne', $month)
                  ->whereYear('date_panne', $year);
        })->get();
    }

    // Récupérer les véhicules qui ne sont plus en panne
    public static function getVehiclesNotInPanneByMonth($month, $year)
    {
        return self::whereDoesntHave('pannes', function ($query) use ($month, $year) {
            $query->whereMonth('date_panne', $month)
                  ->whereYear('date_panne', $year);
        })->get();
    }

    // Calculer le coût par véhicule par mois
    public static function getCostPerVehicle($month, $year)
    {
        return self::with('fuelConsumptions')
            ->whereMonth('date_achat', $month)
            ->whereYear('date_achat', $year)
            ->get()
            ->map(function ($vehicle) {
                return [
                    'vehicle' => $vehicle->numero,
                    'cost' => $vehicle->fuelConsumptions->sum('cost') // Remplacer 'cost' par le bon attribut
                ];
            });
    }

    // Kilométrage total par véhicule par mois
    // Kilométrage total par véhicule par mois
  
public static function getKilometragePerVehicle($month, $year)
{
    return self::whereMonth('date_achat', $month)
        ->whereYear('date_achat', $year)
        ->get()
        ->map(function ($vehicle) use ($month, $year) {
            // Correct the field name for fuel consumption date
            $kilometrage = $vehicle->fuelConsumptions()
                ->whereMonth('date_fuel_added', $month)
                ->whereYear('date_fuel_added', $year)
                ->sum('distance_parcourue');

            return [
                'vehicle' => $vehicle->numero, // Assuming 'numero' is the vehicle identifier
                'kilometrage' => $kilometrage,
            ];
        });


    }public function getTechnicalVisitStatusAttribute()
    {
        $lastVisitDate = Carbon::parse($this->date_visite_technique);
        $expiryDate = $lastVisitDate->addYear();
        $now = Carbon::now();
        $diffInDays = $now->diffInDays($expiryDate);

        
        if ($diffInDays <= 15 && $diffInDays >= 0) {
            return " Expiré, il reste {$diffInDays} jour(s)"; 
        }

        
        $diffInMonths = $now->diffInMonths($expiryDate);
        if ($diffInMonths == 3) {
            return " Doit renouveler dans 3 mois";
        } elseif ($diffInMonths == 1) {
            return " Doit renouveler dans 1 mois";
        }

        return "Valide"; 
    }


    // Véhicules proches de la visite technique
    public static function getVehiclesCloseToTechVisit()
    {
        $today = Carbon::today();
        return self::where('date_visite_technique', '<', $today->addDays(30))
                    ->where('date_visite_technique', '>', $today)
                    ->get();
    }

    public function getAverageFuelCostAttribute()
    {
        $totalFuelCost = $this->fuelConsumptions()->sum('cost');
        $totalDistance = $this->fuelConsumptions()->sum('distance_parcourue');

        if ($totalFuelCost > 0 && $totalDistance > 0) {
            return round(($totalFuelCost / $totalDistance) * 100, 2); 
        }

        return null; 
    }
    public function getPannesCountAttribute()
    {
        return $this->pannes()->count(); 
    }
    public function getTotalInterventionCostAttribute()
    {
        return $this->interventions()->sum('total_cost'); 
    }
   

    public static function getTotalCostPerVehicleByMonth($month, $year)
    {
        return self::with(['fuelConsumptions', 'interventions']) // use the correct relationship name
            ->whereMonth('date_achat', $month)
            ->whereYear('date_achat', $year)
            ->get()
            ->map(function ($vehicle) use ($month, $year) {
                $fuelCost = $vehicle->fuelConsumptions() // Corrected the relationship name
                    ->whereMonth('date_fuel_added', $month)
                    ->whereYear('date_fuel_added', $year)
                    ->sum('total_cost');
    
                $interventionCost = $vehicle->interventions()
                    ->whereMonth('date_intervention', $month)
                    ->whereYear('date_intervention', $year)
                    ->sum('total_cost');
    
                return [
                    'vehicle' => $vehicle->numero,
                    'fuel_cost' => $fuelCost,
                    'intervention_cost' => $interventionCost,
                ];
            });
    }
// Inside Vehicule.php

public function interventions()
{
    return $this->hasMany(Intervention::class); // assuming you have an Intervention model
}
    



}