<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TypeIntervention;

class TypeInterventionFactory extends Factory
{
    protected $model = TypeIntervention::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Videonage', 'Visite technique', 'Reparation']),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
