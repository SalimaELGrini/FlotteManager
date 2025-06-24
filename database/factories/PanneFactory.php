<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Panne;
use App\Models\Vehicule;

class PanneFactory extends Factory
{
    protected $model = Panne::class;

    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::inRandomOrder()->first()->id ?? Vehicule::factory(),
            'description' => $this->faker->sentence(),
            'date_panne' => $this->faker->date(),
            'resolved' => $this->faker->boolean(30),
        ];
    }
}
