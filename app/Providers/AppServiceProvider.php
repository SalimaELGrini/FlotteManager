<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

// Repositories
use App\Repositories\Driver\DriverRepositoryInterface;
use App\Repositories\Driver\DriverRepository;
use App\Repositories\FuelConsumption\FuelConsumptionRepositoryInterface;
use App\Repositories\FuelConsumption\FuelConsumptionRepository;
use App\Services\Garage\GarageServiceInterface;
use App\Services\Garage\GarageService;
use App\Repositories\Garage\GarageRepositoryInterface;
use App\Repositories\Garage\GarageRepository;
use App\Repositories\Vehicules\VehiculeRepositoryInterface;
use App\Repositories\Vehicules\VehiculeRepository;
use App\Repositories\Pieces\PieceRepositoryInterface;
use App\Repositories\Pieces\PieceRepository;
use App\Repositories\Pannes\PanneRepository;
use App\Repositories\Pannes\PanneRepositoryInterface;
use App\Repositories\Interventions\InterventionRepositoryInterface;
use App\Repositories\Interventions\InterventionRepository;
use App\Repositories\TypeIntervention\TypeInterventionRepositoryInterface;
use App\Repositories\TypeIntervention\TypeInterventionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding Driver Repository
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);

        // Binding Fuel Consumption Repository
        $this->app->bind(FuelConsumptionRepositoryInterface::class, FuelConsumptionRepository::class);

        $this->app->bind(VehiculeRepositoryInterface::class, VehiculeRepository::class);

        $this->app->bind(PanneRepositoryInterface::class, PanneRepository::class);

        $this->app->bind(PieceRepositoryInterface::class, PieceRepository::class);
        
        $this->app->bind(TypeInterventionRepositoryInterface::class, TypeInterventionRepository::class);

        $this->app->bind(GarageServiceInterface::class, GarageService::class);
        $this->app->bind(GarageRepositoryInterface::class, GarageRepository::class);

        $this->app->bind(
            InterventionRepositoryInterface::class,
            InterventionRepository::class
        );


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pagination avec Bootstrap 5
        Paginator::useBootstrapFive();

        // Partage des notifications selon rôle dans la navbar
        View::composer('layouts.navbars.auth.topnav', function ($view) {
            $user = Auth::user();

            if ($user) {
                $notifications = $user->notifications;

                if ($user->role == 'user') {
                    $notifications = $notifications->where('type', 'approval');
                }

                $view->with('notifications', $notifications);
            }
        });

        // Chargement et partage des paramètres généraux
        $language = Setting::get('language', 'fr');
        $appName = Setting::get('app_name', 'Default App Name');
        app()->setLocale($language);

        View::share('custom_settings', [
            'app_name' => $appName,
            'language' => $language,
            'notifications_enabled' => Setting::get('notifications_enabled', 'true'),
        ]);
    }
}
