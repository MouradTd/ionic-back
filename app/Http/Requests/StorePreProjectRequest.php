<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreProjectRequest extends FormRequest
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
            'type_project' => 'required|string',
            'project_code' => 'required|string',
            'maitre_ouvrage' => 'required|string',
            'n_offre' => 'required|string',
            'objet' => 'required|string',
            'date_depot' => 'required|date',
            'dossier_adminstratif' => 'required|boolean',
            'dossier_technique' => 'required|boolean',
            'offre_financier' => 'required|boolean',
            'dossier_additif' => 'required|boolean',
            'offre_technique' => 'required|boolean',
            'other_docs' => 'required|boolean',
        ];
    }
}
