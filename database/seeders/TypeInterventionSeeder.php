<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeIntervention;

class TypeInterventionSeeder extends Seeder
{
    public function run(): void
    {
        TypeIntervention::factory()->count(20)->create();
    }
}
