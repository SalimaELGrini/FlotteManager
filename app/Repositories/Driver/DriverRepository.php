<?php

namespace App\Repositories\Driver;

use App\Models\Driver;

class DriverRepository implements DriverRepositoryInterface
{
    public function all($search)
    {
        return Driver::where('nom', 'like', "%$search%")->paginate(10);
    }

    public function find($id)
    {
        return Driver::findOrFail($id);
    }

    public function create(array $data)
    {
        return Driver::create($data);
    }

    public function update($id, array $data)
    {
        $driver = Driver::findOrFail($id);
        $driver->update($data);
        return $driver;
    }

    public function delete($id)
    {
        $driver = Driver::findOrFail($id);
        return $driver->delete();
    }
}
