<?php

namespace App\Services\Pieces;

use App\Repositories\Pieces\PieceRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class PieceService
{
    protected $pieceRepository;

    public function __construct(PieceRepositoryInterface $pieceRepository)
    {
        $this->pieceRepository = $pieceRepository;
    }

    public function paginate(array $params, $perPage = 10)
    {
        return $this->pieceRepository->paginate($params, $perPage);
    }

    public function create(array $data)
    {
        return $this->pieceRepository->create($data);
    }

    public function find($id)
    {
        return $this->pieceRepository->find($id);
    }

    public function update($id, array $data)
    {
        return $this->pieceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->pieceRepository->delete($id);
    }

    public function search(string $query)
    {
        return $this->pieceRepository->search($query);
    }

    public function generateSinglePdf($id)
    {
        $piece = $this->find($id);

        $locale = app()->getLocale();
        App::setLocale($locale);

        $html = View::make('pages.pieces.piece_single', compact('piece', 'locale'))->render();

        $pdfPath = storage_path('app/public/piece_' . $piece->id . '.pdf');

        ini_set('max_execution_time', 120);

        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe') 
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(90)
            ->save($pdfPath);

        return $pdfPath;
    }
}

