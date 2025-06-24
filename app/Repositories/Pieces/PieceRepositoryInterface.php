<?php

namespace App\Repositories\Pieces;

interface PieceRepositoryInterface
{
    public function paginate(array $params, $perPage = 10);

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function search(string $query);
}
