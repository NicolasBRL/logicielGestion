<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    
    public function index()
    {
        $categories = Categorie::orderBy('created_at', 'ASC')->paginate(35);
        return view('categories', compact('categories'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorieRequest $request)
    { 
        $categorie = Categorie::create($request->validated());

        if($categorie){
            return redirect(route("categories.index"))->with('success', "La catégorie à été crée");
        }

        return redirect(route("categories.index"))->with('success', "La catégorie n'a pas pu être crée");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $category)
    {
        return view('editViews.editCategorie', compact('category'));
    }

    public function update(StoreCategorieRequest $request, Categorie $category)
    {
        $category->update(
            array_merge($request->validated(), [
                'updated_at' => DB::raw('NOW()'),
            ])
        );

        return redirect(route("categories.index"))->with('success', 'Catégorie modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Categorie::find($request->id)->delete();
        return redirect(route('categories.index'))->with('success', 'Catégorie supprimée !');
    }
}
