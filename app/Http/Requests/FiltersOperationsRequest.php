<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiltersOperationsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "filterFirstDate" => 'nullable|date_format:d/m/Y',
            "filterSecondDate" => 'nullable|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'filterFirstDate.format' => 'Le format de la date doit être Jour/Mois/Annee',
            'filterSecondDate.format' => 'Le format de la date doit être Jour/Mois/Annee',
        ];
    }
}
