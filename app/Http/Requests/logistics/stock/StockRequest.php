<?php

namespace App\Http\Requests\logistics\stock;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            "designation" => "required|string",
            "prix" => "required|numeric",
            "category" => "required|string",
            "fournisseur" => "required|string",
            "code" => "required|string",
            "date_achat" => "required|date",
            "etat" => "required|string",
            "emplacement" => "required|string",
            "type_category" => "required|in:informatique,fourniture,autre",
            "description" => "nullable|string",
        ];
    }
}
