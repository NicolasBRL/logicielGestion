<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Déterminez si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email' => 'Email incorrect.',
            'password' => 'Mot de passe incorrect.',
            'email.required' => 'Un email est requis',
            'password.required' => 'Un mot de passe est requis',
        ];
    }

    /**
     * Obtenir les informations de connexion
     */
    public function getCredentials()
    {
        return $this->only('email', 'password');
    }
}
