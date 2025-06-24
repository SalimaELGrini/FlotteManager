<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FuelConsumption extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicule_id',
        'fuel_added',
        'date_fuel_added',
        'fuel_price_per_liter',
        'total_cost',
        'station_service',
        'distance_parcourue',
        'fuel_efficiency',
        'commentaire',
    ];


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($consommation) {
            // calcul total_cost
            $consommation->total_cost = $consommation->fuel_added * $consommation->fuel_price_per_liter;

            // calcul fuel_efficiency (إلا كان fuel_added > 0 باش نتفادو division by zero)
            if ($consommation->fuel_added > 0) {
                $consommation->fuel_efficiency = $consommation->distance_parcourue / $consommation->fuel_added;
            } else {
                $consommation->fuel_efficiency = 0;
            }
        });
    }

    // Accessor
    public function getFuelEfficiencyAttribute()
    {
        if ($this->fuel_added > 0 && $this->distance_parcourue > 0) {
            return round($this->distance_parcourue / $this->fuel_added, 2);
        }
        return null;
    }
   
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


        public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id'); // Make sure the foreign key is correct
    }


}
