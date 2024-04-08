<?php

namespace App\Http\Requests\logistics\pacgsm;

use Illuminate\Foundation\Http\FormRequest;

class AffecterPacGsmRequest extends FormRequest
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
            'pacgsm_id' => 'required|exists:pacgsm,id',
            'employee_id' => 'required|exists:employees,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date',
        ];
    }
}
