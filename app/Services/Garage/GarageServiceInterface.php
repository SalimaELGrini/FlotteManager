<?php

namespace App\Services\Garage;

interface GarageServiceInterface {
    public function getAll();
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
