<?php

namespace App\Repositories\Garage;

use App\Models\Garage;

class GarageRepository implements GarageRepositoryInterface {

    public function getAll() {
        return Garage::orderByDesc('id')->paginate(10);
    }

    public function store(array $data) {
        return Garage::create($data);
    }

    public function find($id) {
        return Garage::findOrFail($id);
    }

    public function update($id, array $data) {
        $garage = Garage::findOrFail($id);
        $garage->update($data);
        return $garage;
    }

    public function delete($id) {
        $garage = Garage::findOrFail($id);
        return $garage->delete();
    }
}
