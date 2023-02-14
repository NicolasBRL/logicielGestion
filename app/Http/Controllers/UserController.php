<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'ASC')->paginate(35);
        return view('users', compact('users'));
    }

    public function store(StoreUtilisateurRequest $request)
    {   
        // Créer l'utilisateur
        $user = User::create(array_merge($request->validated(), [
            'password' => Hash::make($request->password),
        ]));
    
        return redirect(route("utilisateurs.index"))->with('success', 'L\'utilisateur à été créé.');
    }

    public function edit(User $utilisateur)
    {
        return view('editViews.editUtilisateur', compact('utilisateur'));
    }

    public function update(UpdateUtilisateurRequest $request, User $utilisateur)
    {
        $utilisateur->update(array_merge($request->validated(), [
            'password' => Hash::make($request->password),
            'updated_at' => DB::raw('NOW()'),
        ]));

        return redirect(route("utilisateurs.index"))->with('success', 'Utilisateur modifié !');
    }

    public function destroy(Request $request)
    {
        User::find($request->id)->delete();
        return redirect(route('utilisateurs.index'))->with('success', 'Utilisateur supprimé !');
    }
}
