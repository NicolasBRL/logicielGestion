<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'titre' => 'nullable|string|max:255',
            'metaDescription' => 'nullable',
            'contenueHTML' => 'nullable',
        ];
    }
}
