<?php

namespace App\Repositories\TypeIntervention;

interface TypeInterventionRepositoryInterface
{
    public function paginateWithSearch(?string $search = null, int $perPage = 10);
    public function create(array $data);
    public function findOrFail($id);
    public function update($id, array $data);
    public function delete($id);
}
