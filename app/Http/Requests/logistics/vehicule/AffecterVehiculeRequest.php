<?php

namespace App\Http\Requests\logistics\vehicule;

use Illuminate\Foundation\Http\FormRequest;

class AffecterVehiculeRequest extends FormRequest
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
            'id_vehicule' => 'required|numeric',
            'id_employee' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date'
        ];
    }
}
