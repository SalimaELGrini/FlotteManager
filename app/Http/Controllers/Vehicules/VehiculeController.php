<?php

namespace App\Http\Controllers\Vehicules;

use App\Http\Controllers\Controller;
use App\Services\Vehicules\VehiculeService;
use App\Http\Requests\Vehicules\StoreVehiculeRequest;
use App\Http\Requests\Vehicules\UpdateVehiculeRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vehicule;
class VehiculeController extends Controller
{
    protected $vehiculeService;

    public function __construct(VehiculeService $vehiculeService)
    {
        $this->vehiculeService = $vehiculeService;
    }

    public function index(Request $request)
    {
        if (!Gate::allows('createVehicule')) {
            abort(403);
        }

        return $this->vehiculeService->getVehiculesList($request);
    }

    public function search(Request $request)
    {
        if (!Gate::allows('createVehicule')) {
            abort(403);
        }

        return $this->vehiculeService->searchVehicule($request);
    }
    
    public function create()
    {
        if (!Gate::allows('createVehicule')) {
            abort(403);
        }

        $drivers = Driver::all();
        return view('pages.vehicules.create', compact('drivers'));
    }

    public function store(StoreVehiculeRequest $request)
    {
        if (!Gate::allows('assignDriver')) {
            return redirect()->route('vehicules.index')->with('error', 'Vous n\'avez pas la permission d\'assigner un conducteur.');
        }

        $this->vehiculeService->createVehicule($request->validated());

        return redirect()->route('vehicules.index')->with('success', 'Véhicule créé avec succès.');
    }

    public function show(Vehicule $vehicule)
    {
        if (!Gate::allows('createVehicule')) {
            abort(403);
        }

        $vehicule = $this->vehiculeService->getVehiculeWithDrivers($vehicule->id);

        return view('pages.vehicules.show', compact('vehicule'));
    }

    public function edit(Vehicule $vehicule)
    {
        if (!Gate::allows('editVehicule')) {
            abort(403);
        }

        $vehicule = $this->vehiculeService->getVehiculeById($vehicule->id);

        return view('pages.vehicules.edit', compact('vehicule'));
    }

    public function update(UpdateVehiculeRequest $request, Vehicule $vehicule)
    {
        if (!Gate::allows('editVehicule')) {
            abort(403);
        }

        $this->vehiculeService->updateVehicule($request, $vehicule);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule mis à jour avec succès.');
    }

    public function destroy(Vehicule $vehicule)
    {
        if (!Gate::allows('deleteVehicule')) {
            abort(403);
        }

        $this->vehiculeService->deleteVehicule($vehicule);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
    }


    public function generateSinglePdf(Vehicule $vehicule)
{
    

    $pdfPath = $this->vehiculeService->generateVehiculePdf($vehicule->id);

    return response()->download($pdfPath)->deleteFileAfterSend(true);
}


}
