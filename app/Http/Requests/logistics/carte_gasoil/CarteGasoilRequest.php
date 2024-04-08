<?php

namespace App\Http\Requests\logistics\carte_gasoil;

use Illuminate\Foundation\Http\FormRequest;

class CarteGasoilRequest extends FormRequest
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
            'code' => 'required|unique:carte_gasoil,code',
            'type' => 'required|string',
            'status' => 'string|nullable',
            'limit' => 'required|numeric'
        ];
    }
}
