<?php
namespace App\Http\Controllers\Pannes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pannes\StorePanneRequest;
use App\Http\Requests\Pannes\UpdatePanneRequest;
use App\Services\Pannes\PanneService;
use Illuminate\Http\Request;
class PanneController extends Controller
{
    protected $panneService;

    public function __construct(PanneService $panneService)
    {
        $this->panneService = $panneService;
    }
    

    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('managePanne'), 403);

        $data = $this->panneService->getPannesWithFilters($request);

        return view('pages.pannes.index', $data);
    }

    public function create()
    {
        abort_unless(auth()->user()->can('managePanne'), 403);

        $data = $this->panneService->getDataForCreate();

        return view('pages.pannes.create', $data);
    }
    public function store(StorePanneRequest $request)
    {
        abort_unless(auth()->user()->can('managePanne'), 403);

        $panne = $this->panneService->createPanne($request->validated());

        return redirect()
            ->route('pannes.index', ['open_intervention' => true, 'panne_id' => $panne->id])
            ->with('success', 'Panne ajoutée avec succès.');
    }

    public function show($id)
    {
        abort_unless(auth()->user()->can('managePanne'), 403);

        $panne = $this->panneService->getPanneDetails($id);

        return view('pages.pannes.show', compact('panne'));
    }

   
    public function update(UpdatePanneRequest $request, $id)
    {
        if (!auth()->user()->can('managePanne')) {
            abort(403);
        }

        $validated = $request->validated();

        // Convert resolved checkbox presence to boolean
        $validated['resolved'] = $request->has('resolved');

        $this->panneService->updatePanne($id, $validated);

        return redirect()->route('pannes.index')->with('success', 'Panne modifiée avec succès.');
    }


    public function edit($id)
    {
        if (!auth()->user()->can('managePanne')) {
            abort(403);
        }

        $data = $this->panneService->getPanneWithRelations($id);

        return view('pages.pannes.edit', $data);
    }

    


    public function destroy($id)
    {
        if (!auth()->user()->can('delete-pannes')) abort(403);

        $this->panneService->deletePanne($id);

        return redirect()->route('pannes.index')->with('success', 'Panne supprimée avec succès');
    }

    public function search(Request $request)
    {
        if (!auth()->user()->can('managePanne')) abort(403);

        $searchValue = $request->input('vehicule_numero');
        $pannes = $this->panneService->searchPannes($searchValue);

        return response()->json([
            'pannes' => $pannes,
            'csrf' => csrf_token(),
        ]);
    }

    public function ajaxIntervention(Request $request)
    {
        $validated = $request->validate([
            'panne_id' => 'required|exists:pannes,id',
            'vehicule_id' => 'required|exists:vehicules,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'garage_id' => 'required|exists:garages,id',
            'date_intervention' => 'required|date',
            'nom_technician' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        $this->panneService->createIntervention($validated, $user);

        return response()->json([
            'success' => true,
            'message' => 'Intervention ajoutée avec succès.'
        ]);
    }

    public function exportPDF($id)
    {
        $pdfPath = $this->panneService->exportPannePDF($id);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

}

