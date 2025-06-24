<?php

namespace App\Repositories\Vehicules;
use App\Models\Vehicule;
use Illuminate\Http\Request;

interface VehiculeRepositoryInterface
{
    public function query();
    public function find($id);
    public function whereId($id);
    public function applyFilters($query, Request $request);
    public function create(array $data): Vehicule;
    public function findById(int $id): Vehicule;
    public function findWithDriversById(int $id): Vehicule;

    public function update(Vehicule $vehicule, array $data): bool;
    public function delete(Vehicule $vehicule): bool;

    public function detachDrivers(int $vehiculeId): void;

    public function attachDrivers(int $vehiculeId, array $driverIds): void;

    public function findWithDetails(int $id): Vehicule;


}

