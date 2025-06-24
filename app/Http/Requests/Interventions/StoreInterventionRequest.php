<?php


namespace App\Http\Requests\Interventions;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterventionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !\Gate::denies('createIntervention');
    }

    public function rules(): array
    {
        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'panne_id' => 'required|exists:pannes,id',
            'garage_id' => 'required|exists:garages,id',
            'description' => 'nullable|string',
            'date_intervention' => 'required|date',
            'duration' => 'required|date_format:H:i',
            'parts_used' => 'required|string',
            'total_cost' => 'required|numeric|min:0',
            'nom_technician' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicule_id.required' => 'Le véhicule est obligatoire.',
            'vehicule_id.exists' => 'Le véhicule sélectionné est invalide.',
            'type_intervention_id.required' => 'Le type d\'intervention est obligatoire.',
            'type_intervention_id.exists' => 'Le type d\'intervention sélectionné est invalide.',
            'panne_id.exists' => 'La panne sélectionnée est invalide.',
            'garage_id.exists' => 'Le garage sélectionné est invalide.',
            'date_intervention.required' => 'La date de l\'intervention est obligatoire.',
            'date_intervention.date' => 'La date de l\'intervention est invalide.',
            'duration.date_format' => 'La durée doit être au format HH:MM.',
            'total_cost.numeric' => 'Le coût total doit être un nombre.',
            'total_cost.min' => 'Le coût total ne peut pas être négatif.',
            'nom_technician.max' => 'Le nom du technicien ne doit pas dépasser 255 caractères.',
        ];
    }
}