<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    /**
     * Récupère le nom d'une catégorie
     */
    public static function getNomCategorie($id)
    {
        return Categorie::find($id)->nom;
    }

    /**
     * Récupère le nom de plusieurs catégories
     */
    public static function getNomCategories($ids)
    {
        $categorieArr = [];
        foreach(Categorie::whereIn('id', $ids)->get() as $categorie){
            $categorieArr[] = $categorie->nom;
         }
         
        return implode(', ', $categorieArr);
    }
}
