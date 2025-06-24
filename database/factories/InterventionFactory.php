<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Intervention;
use App\Models\Vehicule;
use App\Models\TypeIntervention;
use App\Models\Panne;
use App\Models\Garage;

class InterventionFactory extends Factory
{
    protected $model = Intervention::class;

    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::inRandomOrder()->first()->id ?? Vehicule::factory(),
            'type_intervention_id' => TypeIntervention::inRandomOrder()->first()->id ?? TypeIntervention::factory(),
            'panne_id' => Panne::inRandomOrder()->first()->id ?? Panne::factory(),
            'garage_id' => Garage::inRandomOrder()->first()->id ?? Garage::factory(),
            'description' => $this->faker->paragraph(),
            'date_intervention' => $this->faker->date(),
            'duration' => $this->faker->time(),
            'parts_used' => $this->faker->text(),
            'total_cost' => $this->faker->randomFloat(2, 50, 500),
            'nom_technician' => $this->faker->name(),
        ];
    }
}
