<?php

namespace App\Repositories\FuelConsumption;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\FuelConsumption;

interface FuelConsumptionRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): ?FuelConsumption;
    public function create(array $data): FuelConsumption;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
