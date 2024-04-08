<?php

namespace App\Http\Requests\logistics\vehicule;

use Illuminate\Foundation\Http\FormRequest;

class VehiculeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => 'required|string',
            'km' => 'required|numeric',
            'matricule' => 'required|string',
            'date_entree' => 'required|date',
            'model' => 'required|string',
            'num_chassis' => 'required|string',
            'matricule_w' => 'required|string',
            "rented" => 'required|boolean'
        ];
    }
}
