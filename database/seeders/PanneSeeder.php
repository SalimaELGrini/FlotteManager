<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Panne;

class PanneSeeder extends Seeder
{
    public function run(): void
    {
        Panne::factory()->count(20)->create();
    }
}
