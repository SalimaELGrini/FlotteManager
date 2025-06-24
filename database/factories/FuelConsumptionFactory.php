<?php

namespace Database\Factories;

use App\Models\FuelConsumption;
use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelConsumptionFactory extends Factory
{
    protected $model = FuelConsumption::class;

    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::inRandomOrder()->first()->id ?? Vehicule::factory(),
            'fuel_added' => $this->faker->randomFloat(2, 10, 100),  // Kmiya dyal lma3zin
            'date_fuel_added' => $this->faker->date(),
            'fuel_price_per_liter' => $this->faker->randomFloat(2, 5, 20),  // Thman dyal lma3zin
            'total_cost' => $this->faker->randomFloat(2, 50, 200),  // Lmchrou3 kolchi
            'station_service' => $this->faker->company(),  // Station dyal lma3zin
            'distance_parcourue' => $this->faker->randomFloat(2, 0, 500),  // Massafa
            'fuel_efficiency' => $this->faker->randomFloat(2, 0, 10),  // L'efficacité dyal lma3zin
            'commentaire' => $this->faker->optional()->sentence(),  // Commentaire
        ];
    }
}
