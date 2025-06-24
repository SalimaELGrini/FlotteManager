<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
            'numero_permis' => $this->faker->unique()->numerify('###########'),
            'type_permis' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'date_expiration_permis' => $this->faker->date(),
            'adresse' => $this->faker->address(),
            'date_embauche' => $this->faker->date(),
            'contact_urgence' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['disponible', 'occupe', 'en pause', 'non disponible']),
        ];
    }
}
