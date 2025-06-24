<?php

namespace App\Http\Requests\Pannes;

use Illuminate\Foundation\Http\FormRequest;

class StorePanneRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('managePanne');
    }

    public function rules()
    {
        return [
            'vehicule_id'      => 'required|exists:vehicules,id',
            'description'      => 'required|string|max:255',
            'date_panne'       => 'required|date|before_or_equal:today',
            'resolved'         => 'nullable|boolean',
            'driver_id'        => 'nullable|exists:drivers,id',
            'status'           => 'nullable|in:avant,en_cours',
        ];
    }

    public function messages()
    {
        return [
            'vehicule_id.required'     => 'Le véhicule est obligatoire.',
            'vehicule_id.exists'       => 'Le véhicule sélectionné est invalide.',
            'description.required'     => 'La description est obligatoire.',
            'description.string'       => 'La description doit être une chaîne de caractères.',
            'description.max'          => 'La description ne doit pas dépasser 255 caractères.',
            'date_panne.required'      => 'La date de la panne est obligatoire.',
            'date_panne.date'          => 'La date de la panne doit être une date valide.',
            'date_panne.before_or_equal' => 'La date de la panne ne peut pas être dans le futur.',
            'resolved.boolean'         => 'Le champ "résolue" doit être vrai ou faux.',
            'driver_id.exists'         => 'Le conducteur sélectionné est invalide.',
            'status.in'                => 'Le statut doit être soit "avant", soit "en cours".',
        ];
    }
}
