<?php

namespace App\Services\TypeIntervention;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use App\Repositories\TypeIntervention\TypeInterventionRepositoryInterface;

class TypeInterventionService
{
    protected $repo;

    public function __construct(TypeInterventionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function paginateWithSearch($search)
    {
        return $this->repo->paginateWithSearch($search);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function find($id)
    {
        return $this->repo->findOrFail($id);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
    public function generateSinglePdf($id): string
    {
        $typeIntervention = $this->find($id);
        $locale = App::getLocale();

        $html = View::make('pages.type_interventions.type_single', compact('typeIntervention', 'locale'))->render();

        $pdfPath = storage_path('app/public/type_intervention_' . $id . '.pdf');

        ini_set('max_execution_time', 120);

        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe') 
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(300)
            ->save($pdfPath);

        return $pdfPath;
    }
}
