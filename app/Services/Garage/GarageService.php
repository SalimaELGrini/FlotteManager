<?php

namespace App\Services\Garage;

use App\Repositories\Garage\GarageRepositoryInterface;

class GarageService implements GarageServiceInterface {

    protected $garageRepo;

    public function __construct(GarageRepositoryInterface $garageRepo) {
        $this->garageRepo = $garageRepo;
    }

    public function getAll() {
        return $this->garageRepo->getAll();
    }

    public function store(array $data) {
        return $this->garageRepo->store($data);
    }

    public function find($id) {
        return $this->garageRepo->find($id);
    }

    public function update($id, array $data) {
        return $this->garageRepo->update($id, $data);
    }

    public function delete($id) {
        return $this->garageRepo->delete($id);
    }
}
