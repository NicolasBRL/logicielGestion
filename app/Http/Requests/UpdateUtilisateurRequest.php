<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUtilisateurRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Récupère les valeurs du user.
        $user = request()->route('utilisateur');

        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ];
    }

    public function messages(){
        return [
            'name' => 'Nom incorrect.',
            'email' => 'Email incorrect.',
            
            'name.required' => 'Le nom doit être complété.',
            'email.required' => 'L\'email doit être complété.',
            
            'email.unique' => 'L\'email est déjà utilisé pour un autre compte',

            'password.min' => 'Le mot de passe doit contenir minimum 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moin une lettre',
            'password.regex' => 'Le mot de passe doit contenir au moin un numéro',
            'password.regex' => 'Le mot de passe doit contenir au moin un caractère spécial (@$!%*#?&)',
        ];
    }
}
