<?php

namespace App\Http\Requests\logistics\pacgsm;

use Illuminate\Foundation\Http\FormRequest;

class PacGsmRequest extends FormRequest
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
            'num' => 'required|string|unique:pacgsm,num',
            'price' => 'required|numeric',
            'operator' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:sim,ADSL,FTTH,Autre,Routeur',
            'status' => 'nullable|in:active,in stock',
            'price_ht' => 'numeric|nullable',
            'date_activation' => 'required|date',
            'date_resiliation' => 'nullable|date',
        ];
    }
}
