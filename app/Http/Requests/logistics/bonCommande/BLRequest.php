<?php

namespace App\Http\Requests\logistics\bonCommande;

use Illuminate\Foundation\Http\FormRequest;

class BLRequest extends FormRequest
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
            "bl" => "required|file",
            "qtrLivre" => "required|integer",
            "qtrDemande" => "required|integer",
            "bon_commande_id" => "required|integer",
            // "complete" => "required|boolean",
        ];
    }
}
