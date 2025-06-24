<?php
namespace App\Http\Requests\Garage;

use Illuminate\Foundation\Http\FormRequest;

class StoreGarageRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' =>  ['required', 'regex:/^0[6-7][0-9]{8}$/'],
            'email' => 'required|email|unique:garages,email',
            'specializations' => 'required|string',
        ];
    }
}

