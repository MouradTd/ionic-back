<?php

namespace App\Http\Requests\logistics\carte_gasoil;

use Illuminate\Foundation\Http\FormRequest;

class AffecationCarteGasoilRequest extends FormRequest
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
            'id_carte_gasoil' => 'required|exists:pacgsm,id',
            'id_employee' => 'required|exists:employees,id',
            'date_debut' => 'required|date',
            'consommation' => 'required|numeric',
            'comment' => 'nullable|string',
            'date_fin' => 'nullable|date',
        ];
    }
}
