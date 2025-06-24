<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicule;

class VehiculeFactory extends Factory
{
    protected $model = Vehicule::class;

    public function definition(): array
    {
        return [
            'numero' => $this->faker->unique()->bothify('VEH-####'),
            'modele' => $this->faker->randomElement(['Renault Clio', 'Peugeot 208', 'Toyota Yaris', 'Ford Focus']),
            'matricule' => $this->faker->unique()->bothify('###-??-###'),
            'annee_fabrication' => $this->faker->year(),
            'type_carburant' => $this->faker->randomElement(['Essence', 'Diesel', 'Électrique', 'Hybride']),
            'capacite_reservoir' => $this->faker->numberBetween(30, 80),
            'kilometrage' => $this->faker->numberBetween(5000, 200000),
            'date_visite_technique' => $this->faker->date(),
            'date_expiration_assurance' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Disponible', 'En réparation', 'Loué']),
            'date_achat' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
