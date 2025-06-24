<?php

namespace App\Repositories\TypeIntervention;

use App\Models\TypeIntervention;

class TypeInterventionRepository implements TypeInterventionRepositoryInterface
{
    public function paginateWithSearch(?string $search = null, int $perPage = 10)
    {
        $query = TypeIntervention::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return TypeIntervention::create($data);
    }

    public function findOrFail($id)
    {
        return TypeIntervention::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $type = $this->findOrFail($id);
        $type->update($data);

        return $type;
    }

    public function delete($id)
    {
        $type = $this->findOrFail($id);
        return $type->delete();
    }
}
