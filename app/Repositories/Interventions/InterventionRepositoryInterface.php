<?php

namespace App\Repositories\Interventions;

interface InterventionRepositoryInterface
{
    public function getFilteredInterventions($filters);
    public function getFilterOptions();
    public function create(array $data);
    public function findByTechnician(string $name);
    public function countTechnicianMonthly(string $name): int;
    public function update(array $data, int $id);
    public function ajaxStore(array $data);
    public function findByIdWithRelations($id);
    public function findById($id);
    public function getVehiculesGrouped();
    public function getPannesGrouped();
    public function getGaragesGrouped();
    public function getTypesInterventionsGrouped();
    public function delete($id);
    public function getInterventionWithRelations($id, array $relations = []);

}
