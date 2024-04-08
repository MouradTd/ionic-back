<?php

namespace App\Http\Requests\finance;

use Illuminate\Foundation\Http\FormRequest;

class CarnetRequest extends FormRequest
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
            'type' => 'required|string',
            'numero' => 'required|string',
            'qtr' => 'required|numeric',
            'qtr_minimal' => 'required|numeric',
            'compte_bancaire_id' => 'required|numeric',
        ];
    }
}
