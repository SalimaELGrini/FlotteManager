<?php

namespace App\Http\Requests\TypeIntervention;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method \App\Models\User|null user(string|null $guard = null)
 * @method \Illuminate\Routing\Route|string|null route(string|null $param = null, $default = null)
 */

class UpdateTypeInterventionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   

    public function rules(): array 
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('type_interventions', 'name')->ignore($this->route('type_intervention'))
            ],
            'description' => 'nullable|string',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du type d\'intervention est obligatoire.',
            'name.string' => 'Le nom du type d\'intervention doit être une chaîne de caractères.',
            'name.max' => 'Le nom du type d\'intervention ne peut pas dépasser 255 caractères.',
            'name.unique' => 'Ce type d\'intervention existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
        ];
    }
    
}
