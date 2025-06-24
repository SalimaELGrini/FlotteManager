<?php

namespace App\Http\Requests\Interventions;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterventionAjaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'panne_id' => 'required|exists:pannes,id',
            'vehicule_id' => 'required|exists:vehicules,id',
            'type_intervention_id' => 'required|exists:type_interventions,id',
            'garage_id' => 'nullable|exists:garages,id',
            'date_intervention' => 'required|date',
            'nom_technician' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
