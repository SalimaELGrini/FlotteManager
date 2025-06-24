<?php
namespace App\Http\Controllers\FuelConsumptions;

use App\Http\Controllers\Controller;

use App\Services\FuelConsumptions\FuelConsumptionService;
use App\Http\Requests\StoreFuelConsumptionRequest;
use App\Http\Requests\UpdateFuelConsumptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use App\Jobs\ExportFuelConsumptionPDF;

class FuelConsumptionController extends Controller
{
    protected $fuelService;

    public function __construct(FuelConsumptionService $fuelService)
    {
        $this->middleware('can:createFuelConsumption')->only('create', 'store');
        $this->middleware('can:editFuelConsumption')->only('edit', 'update');
        $this->middleware('can:deleteFuelConsumption')->only('destroy');

        $this->fuelService = $fuelService;
    }

    // Liste consommation carburant avec filtres éventuels
    public function index(Request $request)
    {
        $filters = $request->only(['date_filter', 'period', 'first_letter']);
        $fuelConsumptions = $this->fuelService->getAll($filters);
        return view('pages.fuel_consumption.index', compact('fuelConsumptions'));
    }

    // Affichage d'une consommation carburant précise
    public function show($id)
    {
        $fuelConsumption = $this->fuelService->find($id);
        abort_if(!$fuelConsumption, 404);
        return view('pages.fuel_consumption.show', compact('fuelConsumption'));
    }

    // Affichage formulaire création
    public function create()
    {
        $vehicles = \App\Models\Vehicule::all();
        return view('pages.fuel_consumption.create', compact('vehicles'));
    }

    // Enregistrement nouvelle consommation carburant
    public function store(StoreFuelConsumptionRequest $request)
    {
        $this->fuelService->create($request->validated());
        return redirect()->route('fuel-consumption.index')->with('success', __('Consommation de carburant ajoutée avec succès.'));
    }

    // Affichage formulaire édition
    public function edit($id)
    {
        $fuelConsumption = $this->fuelService->find($id);
        abort_if(!$fuelConsumption, 404);
        $vehicules = \App\Models\Vehicule::all();
        return view('pages.fuel_consumption.edit', compact('fuelConsumption', 'vehicules'));
    }

    // Mise à jour consommation carburant
    public function update(UpdateFuelConsumptionRequest $request, $id)
    {
        $updated = $this->fuelService->update($id, $request->validated());
        if (!$updated) {
            return redirect()->back()->withErrors(__('Failed to update fuel consumption.'));
        }
        return redirect()->route('fuel-consumption.index')->with('success', __('Consommation de carburant mise à jour avec succès.'));
    }

    // Suppression consommation carburant
    public function destroy($id)
    {
        $deleted = $this->fuelService->delete($id);
        if (!$deleted) {
            return redirect()->back()->withErrors(__('Failed to delete fuel consumption.'));
        }
        return redirect()->route('fuel-consumption.index')->with('success', __('Consommation de carburant supprimée avec succès.'));
    }

    

    public function exportPDF($id)
    {
        $pdfPath = $this->fuelService->exportPDF($id);
    
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
    

}





