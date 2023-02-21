<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    use HasFactory;

    protected $table = 'site_informations';
    protected $fillable = ['titre', 'contenueHTML', 'metaDescription'];

    public static function getTitre()
    {
        return SiteInfo::get()->pluck('titre')[0];
    }

    public static function getContenueHTML()
    {
        return SiteInfo::get()->pluck('contenueHTML')[0];
    }

    public static function getMetaDesc()
    {
        return SiteInfo::get()->pluck('metaDescription')[0];
    }

    public static function exist()
    {
        return (SiteInfo::first()) ? true : false;
    }
}
