<?php

namespace App\Http\Requests\Vehicules;


use Illuminate\Foundation\Http\FormRequest;

class StoreVehiculeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero' => 'required|string|max:255|unique:vehicules,numero',
            'modele' => 'required|string|max:255',
            'matricule' => 'required|string|max:255|unique:vehicules,matricule',
            'annee_fabrication' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'type_carburant' => 'required|string|max:255',
            'capacite_reservoir' => 'required|integer|min:1',
            'kilometrage' => 'required|integer|min:0',
            'date_visite_technique' => 'required|date|after_or_equal:today',
            'date_expiration_assurance' => 'required|date|after:today',
            'status' => 'required|string|in:Disponible,Indisponible,En Réparation',
            'date_achat' => 'required|date|before_or_equal:today',
            'driver_id' => 'nullable|array',
            'driver_id.*' => 'exists:drivers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'numero.required' => 'Le numéro est obligatoire.',
            'numero.unique' => 'Ce numéro existe déjà.',
            'modele.required' => 'Le modèle est obligatoire.',
            'matricule.required' => 'Le numéro de matricule est obligatoire.',
            'matricule.unique' => 'Ce numéro de matricule existe déjà.',
            'annee_fabrication.digits' => "L'année de fabrication doit être composée de 4 chiffres.",
            'annee_fabrication.min' => "L'année de fabrication doit être après 1900.",
            'annee_fabrication.max' => "L'année de fabrication ne peut pas dépasser l'année actuelle.",
            'date_visite_technique.after_or_equal' => 'La date de visite technique doit être aujourd\'hui ou dans le futur.',
            'date_expiration_assurance.after' => 'La date d\'expiration de l\'assurance doit être dans le futur.',
            'status.in' => 'Le statut doit être: Disponible, Indisponible ou En Réparation.',
            'date_achat.before_or_equal' => "La date d'achat ne peut pas être dans le futur.",
        ];
    }
}
