<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nom" => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Vous devez renseigner le nom de la catégorie.',
            'nom.max' => 'Le nom doit contenir maximum 255 charactères.',
        ];
    }
}
