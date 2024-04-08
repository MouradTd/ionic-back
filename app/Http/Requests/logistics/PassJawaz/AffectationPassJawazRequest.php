<?php

namespace App\Http\Requests\logistics\PassJawaz;

use Illuminate\Foundation\Http\FormRequest;

class AffectationPassJawazRequest extends FormRequest
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
            'employee_id' => 'required|exists:employees,id',
            'pass_jawaz_id' => 'required|exists:pass_jawaz,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date',
        ];
    }
}
