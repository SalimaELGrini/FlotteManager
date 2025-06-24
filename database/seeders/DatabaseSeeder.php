<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Vérifier si l'utilisateur existe déjà pour éviter l'erreur
        if (!User::where('email', 'admin@argon.com')->exists()) {
            DB::table('users')->insert([
                'username' => 'admin',
                'firstname' => 'Admin',
                'lastname' => 'Admin',
                'email' => 'admin@argon.com',
                'password' => bcrypt('secret')
            ]);
        }

        // Exécuter les autres seeders
        $this->call([
            PieceSeeder::class,
            VehiculeSeeder::class,
            DriverSeeder::class,
            AssignmentSeeder::class,
            GarageSeeder::class,
            PanneSeeder::class,
            TypeInterventionSeeder::class,
            InterventionSeeder::class,
            FuelConsumptionSeeder::class,
            NeussiteSeeder::class,
          

        ]);
    }
}
