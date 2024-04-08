<?php

namespace App\Http\Requests\logistics\louer;

use Illuminate\Foundation\Http\FormRequest;

class LouerRequest extends FormRequest
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
            'date' => 'required|date',
            'designation' => 'required|string',
            'montant' => 'required|numeric',
            'mode_paiement' => 'required|string',
            'recepteur' => 'required|string',
            'a_payer' => 'boolean',
            'type' => 'required|string',
            'adresse' => 'string|nullable',
        ];
    }
}
