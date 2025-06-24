<?php

namespace App\Repositories\Vehicules;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeRepository implements VehiculeRepositoryInterface
{
    public function query()
    {
        return Vehicule::query();
    }

    public function find($id)
    {
        return Vehicule::find($id);
    }

    public function whereId($id)
    {
        return Vehicule::where('id', $id);
    }

    public function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where('matricule', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('year_filter')) {
            $query->whereYear('created_at', $request->year_filter);
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'last_2_days':
                    $query->whereDate('created_at', '>=', today()->subDays(2));
                    break;
                case 'last_3_days':
                    $query->whereDate('created_at', '>=', today()->subDays(3));
                    break;
                case 'last_7_days':
                    $query->whereDate('created_at', '>=', today()->subDays(7));
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
                case 'last_2months':
                    $query->whereMonth('created_at', now()->subMonths(2)->month);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', now()->subYear()->year);
                    break;
            }
        }

        if ($request->filled('date_filter')) {
            $query->whereDate('created_at', $request->date_filter);
        }

        return $query;
    }

    public function create(array $data): Vehicule
    {
        return Vehicule::create(collect($data)->except('driver_id')->toArray());
    }

    public function findById(int $id): Vehicule
{
    return Vehicule::findOrFail($id);
}

    public function findWithDriversById(int $id): Vehicule
    {
        return Vehicule::with('assignments.driver')->findOrFail($id);
    }

    public function update(Vehicule $vehicule, array $data): bool
    {
        return $vehicule->update($data);
    }

    public function delete(Vehicule $vehicule): bool
    {
        return $vehicule->delete();
    }

    public function detachDrivers(int $vehiculeId): void
    {
        $vehicule = Vehicule::findOrFail($vehiculeId);
        $vehicule->drivers()->sync([]);
    }

    public function attachDrivers(int $vehiculeId, array $driverIds): void
    {
        $vehicule = Vehicule::findOrFail($vehiculeId);
        foreach ($driverIds as $driverId) {
            $vehicule->drivers()->attach($driverId, ['assigned_at' => now()]);
        }
    }
    public function findWithDetails(int $id): Vehicule
    {
        return Vehicule::with('assignments.driver')->findOrFail($id);
    }

}
