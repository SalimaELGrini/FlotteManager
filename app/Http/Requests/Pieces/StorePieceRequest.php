<?php

namespace App\Http\Requests\Pieces;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @method \App\Models\User|null user(string|null $guard = null)
 */
class StorePieceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('createPiece');
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:pieces,reference',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la pièce est obligatoire.',
            'reference.required' => 'La référence est obligatoire.',
            'reference.unique' => 'Cette référence est déjà utilisée.',
            'type.required' => 'Le type est obligatoire.',
        ];
    }
}

