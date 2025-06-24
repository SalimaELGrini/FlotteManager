<?php

namespace App\Services\Drivers;

use App\Repositories\Driver\DriverRepositoryInterface;

class DriverService
{
    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function getAllDrivers($search)
    {
        return $this->driverRepository->all($search);
    }

    public function findDriverById($id)
    {
        return $this->driverRepository->find($id);
    }

    public function createDriver(array $data)
    {
        return $this->driverRepository->create($data);
    }

    public function updateDriver($id, array $data)
    {
        return $this->driverRepository->update($id, $data);
    }

    public function deleteDriver($id)
    {
        return $this->driverRepository->delete($id);
    }
    
}
