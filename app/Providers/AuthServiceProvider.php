<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('access-admin-area', function ($user) {
            return $user->id === 1; // superadmin only (ID = 1)
        });

    Gate::define('access-admin-dashboard', function ($user) {
        return in_array($user->role, ['admin', 'user']);
    });

        // === Role Gates ===
        Gate::define('isAdmin', fn($user) => $user->role === 'admin');
        Gate::define('isUser', fn($user) => $user->role === 'user');

        // === Véhicules ===
        Gate::define('createVehicule', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editVehicule', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deleteVehicule', fn($user) => $user->role === 'admin');

        // === Conducteurs ===
        Gate::define('createDriver', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editDriver', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('viewDriver', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deleteDriver', fn($user) => $user->role === 'admin');

        // === Assignations ===
        Gate::define('assignDriver', fn($user) => in_array($user->role, ['admin', 'user']));

        // === Garages ===
        Gate::define('createGarage', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editGarage', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('viewGarage', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deleteGarage', fn($user) => $user->role === 'admin');

        // === Pannes ===
        Gate::define('managePanne', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('delete-pannes', function ($user) {
            return $user->role === 'admin';
        });
        
        // === Interventions ===
        Gate::define('createIntervention', fn($user)=> in_array($user->role, ['admin', 'user']));
        Gate::define('editIntervention', fn($user)=> in_array($user->role, ['admin', 'user']));
        Gate::define('deleteIntervention', fn($user) => $user->role === 'admin');

        // === TypeInterventions ===
        //Gate::define('manageTypeIntervention', fn($user) => $user->role === 'admin');
        // === TypeInterventions ===
        Gate::define('createTypeIntervention', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editTypeIntervention', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('viewTypeIntervention', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deleteTypeIntervention', fn($user) => $user->role === 'admin');



        // === Fuel Consumption ===
        Gate::define('createFuelConsumption', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editFuelConsumption', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deleteFuelConsumption', fn($user) => $user->role === 'admin');

        // === Pièces ===
       
        
        Gate::define('viewPiece', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('createPiece', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('editPiece', fn($user) => in_array($user->role, ['admin', 'user']));
        Gate::define('deletePiece', fn($user) => $user->role === 'admin');

        // === Neussite ===
        Gate::define('manageNeussite', fn($user) => $user->role === 'admin');

        // === Notifications ===
        Gate::define('manageNotification', fn($user) => $user->role === 'superadmin');

        // === Settings ===
        Gate::define('editSettings', fn($user) => $user->role === 'admin');
    }
}
