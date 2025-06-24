<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Neussite;

class NeussiteSeeder extends Seeder
{
    public function run()
    {
        Neussite::factory()->count(20)->create(); 
    }
}
