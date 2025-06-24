<?php
namespace App\Repositories\FuelConsumption;

use App\Models\FuelConsumption;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FuelConsumptionRepository implements FuelConsumptionRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = FuelConsumption::query();

        if (!empty($filters['date_filter'])) {
            $query->whereDate('date_fuel_added', $filters['date_filter']);
        }
        if (!empty($filters['period'])) {
            switch ($filters['period']) {
                case 'today':
                    $query->whereDate('date_fuel_added', now()->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('date_fuel_added', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereYear('date_fuel_added', now()->year)
                          ->whereMonth('date_fuel_added', now()->month);
                    break;
            }
        }
        if (!empty($filters['first_letter'])) {
            $query->whereHas('vehicule', function ($q) use ($filters) {
                $q->where('matricule', 'LIKE', $filters['first_letter'].'%');
            });
        }

        return $query->with('vehicule')->orderByDesc('created_at')->paginate($perPage);
    }

    public function find(int $id): ?FuelConsumption
    {
        return FuelConsumption::with('vehicule')->find($id);
    }

    public function create(array $data): FuelConsumption
    {
        return FuelConsumption::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $fuelConsumption = $this->find($id);
        if (!$fuelConsumption) {
            return false;
        }
        return $fuelConsumption->update($data);
    }

    public function delete(int $id): bool
    {
        $fuelConsumption = $this->find($id);
        if (!$fuelConsumption) {
            return false;
        }
        return $fuelConsumption->delete();
    }
}
