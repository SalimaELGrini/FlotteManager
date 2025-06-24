<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Intervention;

class InterventionSeeder extends Seeder
{
    public function run(): void
    {
        Intervention::factory()->count(20)->create();  
    }
}
