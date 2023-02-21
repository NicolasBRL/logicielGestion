<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSiteRequest;
use App\Models\SiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SiteInfoController extends Controller
{
    public function home()
    {
        if (SiteInfo::exist()) {
            $infos = [
                'titre' => SiteInfo::getTitre(),
                'contenueHTML' => SiteInfo::getContenueHTML(),
                'metaDesc' => SiteInfo::getMetaDesc(),
                'exist' => 'exist'
            ];
        } else {
            $infos = [
                'titre' => config('app.name'),
                'contenueHTML' => "<h1>Oups! Il semblerai que la page n'a pas encore été crée.. 😕</h1>",
                'metaDesc' => '',
                'exist' => 'not-exist'
            ];
        }

        return view('home', compact('infos'));
    }

    public function index()
    {
        return view('site');
    }

    public function pageBuilder()
    {
        return view('pagebuilder');
    }

    // Update page builder
    public function pageBuilderSave(UpdateSiteRequest $request)
    {
        if (SiteInfo::exist()) {
            SiteInfo::first()->update(array_merge($request->validated(), [
                'contenueHTML' => $request->contenueHTML,
                'updated_at' => DB::raw('NOW()'),
            ]));
        } else {
            SiteInfo::create([
                'titre' => 'Mon titre',
                'metaDescription' => 'Ma méta description',
                'contenueHTML'  => $request->get('contenueHTML'),
            ]);
        }

        return redirect(route("configuration.index"))->with('success', 'Site modifié !');
    }

    // Update site information
    public function update(UpdateSiteRequest $request)
    {
        if (SiteInfo::exist()) {
            SiteInfo::first()->update(array_merge($request->validated(), [
                'updated_at' => DB::raw('NOW()'),
            ]));
        } else {
            SiteInfo::create([
                'titre' => $request->get('titre'),
                'metaDescription' => $request->get('metaDescription'),
                'contenueHTML'  => '',
            ]);
        }

        return redirect(route("configuration.index"))->with('success', 'Site modifié !');
    }

    // Upload website images
    public function uploadImages(Request $request)
    {
        $resultArray = array();
        foreach ($request->file() as $file) {
            // Store image in home directory
            $newImage = $file->storeAs("images", $file->getClientOriginalName());

            $result = array(
                'name' => $file->getClientOriginalName(),
                'type' => 'image',
                'src' => URL::to('/storage/'.$newImage),
                'height' => 350,
                'width' => 250
            );
            // we can also add code to save images in database here.
            array_push($resultArray, $result);
        }

        $response = array( 'data' => $resultArray );
        return json_encode($response);
    }
}
