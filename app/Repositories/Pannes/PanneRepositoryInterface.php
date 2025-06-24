<?php

namespace App\Repositories\Pannes;

use Illuminate\Http\Request;
use App\Models\Panne;
interface PanneRepositoryInterface
{
    public function getAllVehicules();
    public function getAllGarages();
    public function getTypeInterventionsByName(string $name);
    public function getPannesWithFilters(Request $request);
    public function getAllDrivers();
    public function create(array $data);
    public function findWithRelations(int $id);
    public function findById(int $id): ?Panne;
    public function update(Panne $panne, array $data): bool;
    public function deleteById(int $id): bool;
    public function searchByVehiculeNumero(string $numero);
    public function createIntervention(array $data);
    public function findPanneWithRelations(int $id);
}

