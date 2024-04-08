<?php

namespace App\Http\Requests\finance;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest
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
            'numero' => 'required',
            'montant' => 'required',
            'date_emission' => 'required',
            'date_encaissement' => 'required',
            'statut' => 'required',
            'remarque' => 'required',
            'tier_id' => 'required',
            'carnet_id' => 'required',
        ];
    }
}
