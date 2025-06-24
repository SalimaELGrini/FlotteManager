<?php

namespace App\Repositories\Pannes;

use App\Models\Vehicule;
use App\Models\Garage;
use App\Models\TypeIntervention;
use App\Models\Intervention;
use App\Models\Panne;
use App\Models\Driver;
use Illuminate\Http\Request;

class PanneRepository implements PanneRepositoryInterface
{
    public function getAllVehicules()
    {
        return Vehicule::all();
    }

    public function getAllGarages()
    {
        return Garage::all();
    }

    public function getTypeInterventionsByName(string $name)
    {
        return TypeIntervention::where('name', $name)->get();
    }

    public function getPannesWithFilters(Request $request)
    {
        $query = Panne::with('vehicule')->whereDoesntHave('interventions');

        if ($request->filled('resolved')) {
            $resolved = $request->resolved == 'Résolue ' ? true : false;
            $query->where('resolved', $resolved);
        }

        if ($request->filled('search')) {
            $query->whereHas('vehicule', function ($q) use ($request) {
                $q->where('numero', 'like', '%' . $request->search . '%');
            });
        }

        return $query->orderBy('date_panne', 'desc')->paginate(10);
    }

    public function getAllDrivers()
    {
        return Driver::all();
    }

    public function create(array $data)
    {
        return Panne::create($data);
    }

    public function findWithRelations(int $id)
    {
        return Panne::with(['vehicule', 'driver', 'interventions.typeIntervention', 'interventions.garage'])->findOrFail($id);
    }

    public function findById(int $id): ?Panne
    {
        return Panne::find($id);
    }

    public function update(Panne $panne, array $data): bool
    {
        return $panne->update($data);
    }
    public function deleteById(int $id): bool
    {
        $panne = Panne::findOrFail($id);
        return $panne->delete();
    }

    public function searchByVehiculeNumero(string $numero)
    {
        return Panne::whereHas('vehicule', function ($query) use ($numero) {
            $query->where('numero', 'like', '%' . $numero . '%');
        })
        ->whereDoesntHave('interventions')
        ->where('resolved', false)
        ->get();
    }

    public function createIntervention(array $data)
    {
        return Intervention::create($data);
    }

    public function findPanneWithRelations(int $id)
    {
        return Panne::with(['vehicule', 'driver'])->findOrFail($id);
    }
}
