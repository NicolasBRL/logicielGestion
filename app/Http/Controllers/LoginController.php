<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Affichage de la page login
     * 
     * @return Renderable
     */
    public function show()
    {
        return view('login');
    }

    /**
     * Traitement de la demande de connexion
     * 
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors('Email ou mot de passe incorrect.');
        endif;
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Traitement après la connexion
     */
    protected function authenticated(Request $request, $user) 
    {
        return redirect('/dashboard');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('dashboard');
    }
}
