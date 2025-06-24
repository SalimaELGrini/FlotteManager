<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Neussite;
use App\Models\Intervention;
use App\Models\Piece;

class NeussiteController extends Controller
{
    /**
     * Crée une nouvelle entrée « neussite » (pièce utilisée) pour une intervention.
     * Requête attendue (JSON ou form-data) :
     *  - intervention_id : integer (exists interventions,id)
     *  - piece_id        : integer (exists pieces,id)
     *  - date_change     : date
     *  - status          : in:pending,completed,in_progress
     *  - prix_piece      : numeric|min:0
     *  - nom_technicien  : string|max:255
     */
    public function store(Request $request)
    {
        $request->validate([
            'intervention_id' => 'required|exists:interventions,id',
            'piece_id'        => 'required|exists:pieces,id',
            'date_change'     => 'required|date',
            'status' => 'required|in:en_attente,terminée,en_cours',
            'prix_piece'      => 'required|numeric|min:0',
            'nom_technicien'  => 'required|string|max:255',
        ], [
            'intervention_id.required' => 'L\'intervention est obligatoire.',
            'intervention_id.exists'   => 'L\'intervention sélectionnée est invalide.',

            'piece_id.required'        => 'La pièce est obligatoire.',
            'piece_id.exists'          => 'La pièce sélectionnée est invalide.',

            'date_change.required'     => 'La date de changement est obligatoire.',
            'date_change.date'         => 'La date de changement doit être une date valide.',

            'status.required'          => 'Le statut est obligatoire.',
            'status.in'                => 'Le statut sélectionné est invalide.',

            'prix_piece.required'      => 'Le prix de la pièce est obligatoire.',
            'prix_piece.numeric'       => 'Le prix de la pièce doit être un nombre.',
            'prix_piece.min'           => 'Le prix de la pièce ne peut pas être négatif.',

            'nom_technicien.required'  => 'Le nom du technicien est obligatoire.',
            'nom_technicien.string'    => 'Le nom du technicien doit être une chaîne de caractères.',
            'nom_technicien.max'       => 'Le nom du technicien ne peut pas dépasser 255 caractères.',
        ]);

        // Crée la pièce utilisée
        Neussite::create($request->only([
            'intervention_id',
            'piece_id',
            'date_change',
            'status',
            'prix_piece',
            'nom_technicien',
        ]));

        return response()->json([
            'message' => 'Pièce ajoutée avec succès!',
        ], 201);
    }

    /**
     * Met à jour une entrée existante de neussite (pièce utilisée) pour une intervention.
     * On attend les mêmes champs que store(), mais on filtre l'ID.
     */
    public function update(Request $request, int $interventionId, int $neussiteId)
    {
        // 1) Validation des champs
        $request->validate([
            'piece_id'       => 'required|exists:pieces,id',
            'date_change'    => 'required|date',
            'status' => 'required|in:en_attente,terminée,en_cours',
            'prix_piece'     => 'required|numeric|min:0',
            'nom_technicien' => 'required|string|max:255',
        ], [
            'piece_id.required'        => 'La pièce est obligatoire.',
            'piece_id.exists'          => 'La pièce sélectionnée est invalide.',

            'date_change.required'     => 'La date de changement est obligatoire.',
            'date_change.date'         => 'La date de changement doit être une date valide.',

            'status.required'          => 'Le statut est obligatoire.',
            'status.in'                => 'Le statut sélectionné est invalide.',

            'prix_piece.required'      => 'Le prix de la pièce est obligatoire.',
            'prix_piece.numeric'       => 'Le prix de la pièce doit être un nombre.',
            'prix_piece.min'           => 'Le prix de la pièce ne peut pas être négatif.',

            'nom_technicien.required'  => 'Le nom du technicien est obligatoire.',
            'nom_technicien.string'    => 'Le nom du technicien doit être une chaîne de caractères.',
            'nom_technicien.max'       => 'Le nom du technicien ne peut pas dépasser 255 caractères.',
        ]);

        // 2) Vérifier que l'intervention existe (sécurité supplémentaire)
        $intervention = Intervention::findOrFail($interventionId);

        // 3) Récupérer la neussite liée à cette intervention
        $neussite = Neussite::where('intervention_id', $intervention->id)
                            ->findOrFail($neussiteId);

        // 4) Mettre à jour les champs
        $neussite->update([
            'piece_id'       => $request->input('piece_id'),
            'date_change'    => $request->input('date_change'),
            'status'         => $request->input('status'),
            'prix_piece'     => $request->input('prix_piece'),
            'nom_technicien' => $request->input('nom_technicien'),
        ]);

        return redirect()
        ->route('interventions.show', $interventionId)
        ->with('success', 'Pièce mise à jour avec succès!');
    }

    /**
     * Supprime une entrée de neussite (pièce utilisée) pour une intervention
     */
    public function destroy(int $interventionId, int $neussiteId)
    {
        // 1) Vérifier que l'intervention existe
        $intervention = Intervention::findOrFail($interventionId);

        // 2) Récupérer la neussite liée
        $neussite = Neussite::where('intervention_id', $intervention->id)
                            ->findOrFail($neussiteId);

        // 3) Supprimer
        $neussite->delete();

        return redirect()
        ->route('interventions.show', $interventionId)
        ->with('success', 'Pièce supprimée avec succès !');
    }
}
