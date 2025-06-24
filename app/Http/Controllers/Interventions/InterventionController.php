<?php

namespace App\Http\Controllers\Interventions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intervention;
use Illuminate\Support\Facades\Gate;
use App\Services\Interventions\InterventionService;
use App\Http\Requests\Interventions\StoreInterventionAjaxRequest;
use App\Http\Requests\Interventions\UpdateInterventionRequest;
use App\Http\Requests\Interventions\StoreInterventionRequest;
class InterventionController extends Controller
{
    protected $interventionService;

    public function __construct(InterventionService $interventionService)
    {
        $this->interventionService = $interventionService;
    }

    public function index(Request $request)
    {
        return $this->interventionService->handleIndex($request);
    }

    public function create(Request $request)
    {
        return $this->interventionService->handleCreate($request);
    }
    
    public function store(StoreInterventionRequest $request)
    {
        $this->interventionService->store($request->validated());
        return redirect()->back()->with('success', 'Intervention ajoutée avec succès.');
    }
    
    public function update(UpdateInterventionRequest $request, $id)
    {
        $this->interventionService->update($request->validated(), $id);
        return redirect()->route('interventions.index')->with('success', 'Intervention mise à jour avec succès.');
    }
    public function assignGarage(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'specialisation' => 'nullable|string|max:255',
        ]);
        

        $intervention = Intervention::findOrFail($id);
        $intervention->garage_id = $request->garage_id;
        $intervention->save();

        return response()->json(['message' => 'Garage assigné avec succès.']);
    }


    public function ajaxStore(StoreInterventionAjaxRequest $request)
    {
        $intervention = $this->interventionService->ajaxStore($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Intervention enregistrée avec succès.',
            'data' => $intervention,
        ]);
    }

    public function show($id)
    {
        $intervention = $this->interventionService->findByIdWithRelations($id);

        return view('pages.interventions.show', compact('intervention'));
    }

    public function edit($id)
    {
        $intervention = $this->interventionService->findById($id);
    
        if (Gate::denies('editIntervention', $intervention)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette intervention.');
        }
    
        $vehicules = $this->interventionService->getVehiculesGrouped();
        $pannes = $this->interventionService->getPannesGrouped();
        $garages = $this->interventionService->getGaragesGrouped();
        $typesInterventions = $this->interventionService->getTypesInterventionsGrouped();
    
        return view('pages.interventions.edit', compact(
            'intervention', 'vehicules', 'typesInterventions', 'garages', 'pannes'
        ));
    }
    
    public function destroy($id)
    {
        $intervention = $this->interventionService->findById($id);
    
        if (Gate::denies('deleteIntervention', $intervention)) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette intervention.');
        }
    
        $this->interventionService->delete($id);
    
        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée avec succès.');
    }
    

    public function generateSinglePdf($id)
{
    $pdf = $this->interventionService->generateSinglePdf($id);

    return $pdf;
}


}

