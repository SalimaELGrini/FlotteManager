<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Piece;

class PieceSeeder extends Seeder
{
    public function run(): void
    {
        Piece::factory(20)->create();
    }
}
