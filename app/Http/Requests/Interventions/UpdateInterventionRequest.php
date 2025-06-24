<?php

namespace App\Http\Requests\Interventions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInterventionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'date_intervention' => 'required|date',
            'duration' => 'required',
            'description' => 'required|string',
            'parts_used' => 'nullable|string',
            'total_cost' => 'required|numeric',
            'nom_technician' => 'required|string',
            'garage_id' => 'required|exists:garages,id',
            'panne_id' => 'nullable|exists:pannes,id',
        ];
    }
}

