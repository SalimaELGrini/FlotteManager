<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Garage;

class GarageSeeder extends Seeder
{
    public function run(): void
    {
        Garage::factory()->count(20)->create();
    }
}
