<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    
    public function index()
    {
        $vehicules = Vehicule::all();
        $drivers = Driver::all();
        return view('pages.vehicules.index', compact('vehicules', 'drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'driver_id' => 'required|exists:drivers,id',
            'date_debut' => 'required|date',
            'type_affectation' => 'required|string',
            'remarques'=> 'required|string',
        ]);

        Assignment::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Affectation enregistrée avec succès.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'type_affectation' => 'required|string',
            'remarques' => 'nullable|string',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update([
            'date_debut' => $request->date_debut,
            'type_affectation' => $request->type_affectation,
            'remarques' => $request->remarques,
        ]);

        return redirect()->back()->with('success', 'Affectation modifiée avec succès.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('success', 'Affectation supprimée avec succès.');
    }



}
