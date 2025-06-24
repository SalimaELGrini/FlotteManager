<?php

namespace App\Repositories\Pieces;

use App\Models\Piece;

class PieceRepository implements PieceRepositoryInterface
{
    public function paginate(array $params, $perPage = 10)
    {
        return Piece::paginate($perPage);
    }

    public function create(array $data)
    {
        return Piece::create($data);
    }

    public function find($id)
    {
        return Piece::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $piece = Piece::findOrFail($id);
        $piece->update($data);
        return $piece;
    }

    public function delete($id)
    {
        $piece = Piece::findOrFail($id);
        return $piece->delete();
    }

    public function search(string $query)
    {
        return Piece::where('nom', 'like', "%$query%")
                    ->orWhere('reference', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%")
                    ->get();
    }
}
