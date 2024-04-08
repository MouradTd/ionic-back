<?php

namespace App\Http\Requests\logistics\caisse;

use Illuminate\Foundation\Http\FormRequest;

class CaisseOperationRequest extends FormRequest
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
            'date_operation' => 'required|date',
            'montant' => 'required|numeric',
            'type' => 'required|string',
            'status' => 'string|nullable',
            'operation' => 'required|in:entree,sortie',
            'comment' => 'string',
            'tier_id' => 'nullable|exists:tiers,id',
            'emetteur' => 'string|nullable',
            'recepteur' => 'nullable|numeric',
        ];

    }
}
