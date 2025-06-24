<?php

namespace App\Http\Controllers\TypeIntervention;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypeIntervention\StoreTypeInterventionRequest;
use App\Http\Requests\TypeIntervention\UpdateTypeInterventionRequest;
use App\Services\TypeIntervention\TypeInterventionService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TypeInterventionController extends Controller
{
    protected $typeService;

    public function __construct(TypeInterventionService $typeService)
    {
        $this->typeService = $typeService;
    }

    // Affichage liste avec recherche
    public function index(Request $request)
    {
        $types = $this->typeService->paginateWithSearch($request->search);
        return view('pages.type_interventions.index', compact('types'));
    }

    // Formulaire de création
    public function create()
    {
        Gate::authorize('createTypeIntervention');
        return view('pages.type_interventions.create');
    }

    // Enregistrement
    public function store(StoreTypeInterventionRequest $request)
    {
        Gate::authorize('createTypeIntervention');
        $this->typeService->store($request->validated());

        return redirect()->route('type_interventions.index')->with('success', 'Type d\'intervention ajouté avec succès.');
    }

    // Affichage détails
    public function show($id)
    {
        Gate::authorize('viewTypeIntervention');
        $typeIntervention = $this->typeService->find($id);
        return view('pages.type_interventions.show', compact('typeIntervention'));
    }

    // Formulaire modification
    public function edit($id)
    {
        Gate::authorize('editTypeIntervention');
        $typeIntervention = $this->typeService->find($id);
        return view('pages.type_interventions.edit', compact('typeIntervention'));
    }

    // Mise à jour
    public function update(UpdateTypeInterventionRequest $request, $id)
    {
        Gate::authorize('editTypeIntervention');
        $this->typeService->update($id, $request->validated());

        return redirect()->route('type_interventions.index')->with('success', 'Type d\'intervention mis à jour avec succès.');
    }

    // Suppression
    public function destroy($id)
    {
        Gate::authorize('deleteTypeIntervention');
        $this->typeService->delete($id);

        return redirect()->route('type_interventions.index')->with('success', 'Type d\'intervention supprimé avec succès.');
    }

    // Génération PDF pour un seul enregistrement
    public function generateSinglePdf($id)
    {
        Gate::authorize('viewTypeIntervention');

        $pdfPath = $this->typeService->generateSinglePdf($id);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
