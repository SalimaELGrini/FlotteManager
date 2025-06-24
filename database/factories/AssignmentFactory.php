<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assignment;
use App\Models\Vehicule;
use App\Models\Driver;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::factory(),  // Crée un vehicule automatiquement
            'driver_id' => Driver::factory(),  // Crée un driver automatiquement
            'date_debut' => $this->faker->date(),
            'type_affectation' => $this->faker->randomElement(['Temporaire', 'Permanente']),
            'remarques' => $this->faker->optional()->sentence(),
        ];
    }
}
