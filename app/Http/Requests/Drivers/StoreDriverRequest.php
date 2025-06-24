<?php


namespace App\Http\Requests\Drivers;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'telephone' => 'required|regex:/^0[5-7][0-9]{8}$/|max:15',
            'numero_permis' => 'required|string|unique:drivers,numero_permis',
            'type_permis' => 'required|string|in:A1,B,C,D',
            'date_expiration_permis' => 'required|date|after:today',
            'adresse' => 'required|string|max:255',
            'date_embauche' => 'required|date|before_or_equal:today',
            'contact_urgence' => 'required|regex:/^0[5-7][0-9]{8}$/',
            'status' => 'required|in:disponible,occupe,en pause,non disponible',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex' => 'Le numéro de téléphone doit être un numéro marocain valide.',
            'telephone.max' => 'Le numéro de téléphone ne doit pas dépasser 15 caractères.',
            'numero_permis.required' => 'Le numéro du permis est obligatoire.',
            'numero_permis.unique' => 'Ce numéro de permis est déjà utilisé.',
            'type_permis.required' => 'Le type de permis est obligatoire.',
            'type_permis.in' => 'Le type de permis doit être A1, B, C ou D.',
            'date_expiration_permis.required' => 'La date d’expiration du permis est obligatoire.',
            'date_expiration_permis.date' => 'La date d’expiration doit être une date valide.',
            'date_expiration_permis.after' => 'La date d’expiration doit être postérieure à aujourd’hui.',
            'adresse.required' => 'L’adresse est obligatoire.',
            'adresse.max' => 'L’adresse ne doit pas dépasser 255 caractères.',
            'date_embauche.required' => 'La date d’embauche est obligatoire.',
            'date_embauche.date' => 'La date d’embauche doit être une date valide.',
            'date_embauche.before_or_equal' => 'La date d’embauche doit être aujourd’hui ou avant.',
            'contact_urgence.required' => 'Le contact d’urgence est obligatoire.',
            'contact_urgence.regex' => 'Le contact d’urgence doit être un numéro marocain valide.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être disponible, occupé, en pause ou non disponible.',
        ];
    }
}
