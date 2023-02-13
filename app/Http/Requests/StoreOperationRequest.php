<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nom" => 'required|string|max:255',
            "categories" => 'required',
            "type" => 'required|boolean',
            "montant" => 'required|numeric',
            "date" => 'nullable|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Vous devez renseigner le nom de l\'opération.',
            'nom.max' => 'Le nom doit contenir maximum 255 charactères.',

            'categories.required' => 'Vous devez renseigner la catégorie de l\'opération.',
            'type.required' => 'Vous devez renseigner le type de l\'opération.',

            'montant.required' => 'Vous devez renseigner le montant de l\'opération.',
            'montant.numeric' => 'Le montant doit contenir seulement des chiffres.',

            'date.format' => 'Le format de la date doit être Jour/Mois/Annee',
        ];
    }
}
