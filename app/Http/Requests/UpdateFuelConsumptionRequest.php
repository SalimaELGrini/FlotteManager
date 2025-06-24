<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFuelConsumptionRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'fuel_added' => 'required|numeric|min:0',
            'date_fuel_added' => 'required|date',
            'fuel_price_per_liter' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'station_service' => 'nullable|string|max:255',
            'distance_parcourue' => 'nullable|numeric|min:0',
            'fuel_efficiency' => 'nullable|numeric|min:0',
            'commentaire' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
           'vehicule_id.required' => 'Le véhicule est obligatoire.',
            'vehicule_id.exists' => 'Le véhicule sélectionné est invalide.',
    
            'fuel_added.required' => 'La quantité de carburant ajoutée est obligatoire.',
            'fuel_added.numeric' => 'La quantité de carburant doit être un nombre.',
            'fuel_added.min' => 'La quantité de carburant ne peut pas être négative.',
    
            'date_fuel_added.required' => 'La date de ravitaillement est obligatoire.',
            'date_fuel_added.date' => 'La date de ravitaillement est invalide.',
    
            'fuel_price_per_liter.required' => 'Le prix par litre est obligatoire.',
            'fuel_price_per_liter.numeric' => 'Le prix par litre doit être un nombre.',
            'fuel_price_per_liter.min' => 'Le prix par litre ne peut pas être négatif.',
    
            'total_cost.required' => 'Le coût total est obligatoire.',
            'total_cost.numeric' => 'Le coût total doit être un nombre.',
            'total_cost.min' => 'Le coût total ne peut pas être négatif.',
    
            'station_service.string' => 'Le nom de la station doit être une chaîne de caractères.',
            'station_service.max' => 'Le nom de la station ne peut pas dépasser 255 caractères.',
    
            'distance_parcourue.numeric' => 'La distance parcourue doit être un nombre.',
            'distance_parcourue.min' => 'La distance parcourue ne peut pas être négative.',
    
            'fuel_efficiency.numeric' => 'L’efficacité du carburant doit être un nombre.',
            'fuel_efficiency.min' => 'L’efficacité du carburant ne peut pas être négative.',
    
            'commentaire.string' => 'Le commentaire doit être une chaîne de caractères.',
        ];
    }
}