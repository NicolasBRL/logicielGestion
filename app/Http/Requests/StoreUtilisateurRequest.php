<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUtilisateurRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ];
    }

    public function messages(){
        return [
            'name' => 'Le nom est incorrect.',
            'email' => 'Email incorrect.',

            'name.required' => 'Le nom doit être complété.',
            'email.required' => 'L\'email doit être complété.',
            'password.required' => 'Le mot de passe doit être complété.',

            'email.unique' => 'L\'email est déjà utilisé pour un autre compte.',

            'password.min' => 'Le mot de passe doit contenir minimum 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moin une lettre',
            'password.regex' => 'Le mot de passe doit contenir au moin un numéro',
            'password.regex' => 'Le mot de passe doit contenir au moin un caractère spécial (@$!%*#?&)',
        ];
    }
}
