<?php

namespace App\Repositories\Driver;

interface DriverRepositoryInterface
{
    public function all($search);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
