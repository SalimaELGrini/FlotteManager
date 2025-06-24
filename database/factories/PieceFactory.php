<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Piece;

class PieceFactory extends Factory
{
    protected $model = Piece::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->word(),
            'reference' => strtoupper($this->faker->bothify('??-####')),
            'type' => $this->faker->randomElement(['Freinage', 'Filtration', 'Électrique', 'Moteur']),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
