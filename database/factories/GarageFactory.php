<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Garage;

class GarageFactory extends Factory
{
    protected $model = Garage::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'specializations' => $this->faker->randomElement([
                'Réparation moteur, Changement d’huile, Diagnostic électronique',
                'Freinage, Suspension, Géométrie et parallélisme',
                'Peinture automobile, Carrosserie, Débosselage',
                'Entretien général, Vidange, Révision complète'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
