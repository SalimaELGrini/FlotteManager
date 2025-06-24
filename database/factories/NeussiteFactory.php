<?php

namespace Database\Factories;

use App\Models\Neussite;
use App\Models\Intervention;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Factories\Factory;

class NeussiteFactory extends Factory
{
    protected $model = Neussite::class;

    public function definition()
    {
        return [
            'intervention_id' => Intervention::factory(), // Ghedi ydif 7ajat random mn Intervention
            'piece_id' => Piece::factory(), // Ghedi ydif 7ajat random mn Piece
            'date_change' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'in_progress']),
            'prix_piece' => $this->faker->randomFloat(2, 10, 500), // Random price between 10 and 500
            'nom_technicien' => $this->faker->name(),
        ];
    }
}
