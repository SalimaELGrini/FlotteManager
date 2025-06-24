<?php

namespace App\Http\Controllers\Garages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\StoreGarageRequest;
use App\Http\Requests\Garage\UpdateGarageRequest;
use App\Services\Garage\GarageServiceInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Spatie\Browsershot\Browsershot;

class GarageController extends Controller
{
    protected $garageService;

    public function __construct(GarageServiceInterface $garageService)
    {
        $this->garageService = $garageService;
    }

    public function index()
    {
        $garages = $this->garageService->getAll();
        return view('pages.garages.index', compact('garages'));
    }

    public function create()
    {
        Gate::authorize('createGarage');
        return view('pages.garages.create');
    }

    public function store(StoreGarageRequest $request)
    {
        Gate::authorize('createGarage');
        $this->garageService->store($request->validated());
        return redirect()->route('garages.index')->with('success', __('Garage ajouté avec succès.'));
    }

    public function show($id)
    {
        Gate::authorize('viewGarage');
        $garage = $this->garageService->find($id);
        return view('pages.garages.show', compact('garage'));
    }

    public function edit($id)
    {
        Gate::authorize('editGarage');
        $garage = $this->garageService->find($id);
        return view('pages.garages.edit', compact('garage'));
    }

    public function update(UpdateGarageRequest $request, $id)
    {
        Gate::authorize('editGarage');
        $this->garageService->update($id, $request->validated());
        return redirect()->route('garages.index')->with('success', __('Garage modifié avec succès.'));
    }

    public function destroy($id)
    {
        Gate::authorize('deleteGarage');
        $this->garageService->delete($id);
        return redirect()->route('garages.index')->with('success', __('Garage supprimé avec succès.'));
    }

    public function generateSinglePdf($id)
    {
        Gate::authorize('viewGarage');
        $garage = $this->garageService->find($id);

        $locale = App::getLocale();
        App::setLocale($locale);

        $html = View::make('pages.garages.garage_single', compact('garage', 'locale'))->render();
        $pdfPath = storage_path("app/public/garage_{$id}.pdf");

        ini_set('max_execution_time', 120);

        Browsershot::html($html)
            ->setChromePath('C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe')
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(90)
            ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}

