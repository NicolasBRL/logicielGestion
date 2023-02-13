<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperationRequest;
use App\Models\Categorie;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperationRequest $request)
    { 
        $operation = Operation::create(array_merge($request->validated(), [
            'estCredit' => $request->type,
            'categorieId' => $request->categories,
            'date' => ($request->filled('date')) ? Carbon::createFromFormat('d/m/Y',  $request->date)->format('Y-m-d H:i:s') : now()
        ]));

        if($operation){
            return redirect(route("dashboard"))->with('success', "L'opération à été crée");
        }

        return redirect(route("dashboard"))->with('success', "L'opération n'a pas pu être crée");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Operation $operation)
    {
        $categories = Categorie::all();
        return view('editViews.editOperation', compact('operation', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOperationRequest $request, Operation $operation)
    {
        $operation->update(
            array_merge($request->validated(), [
                'updated_at' => DB::raw('NOW()'),
                'estCredit' => $request->type,
                'categorieId' => $request->categories,
                'date' => ($request->filled('date')) ? Carbon::createFromFormat('d/m/Y',  $request->date)->format('Y-m-d H:i:s') : now()
    
            ])
        );

        return redirect(route("dashboard"))->with('success', 'Opération modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        $operation->delete();
        return redirect(route('categories.index'))->with('success', 'Opération supprimée !');
    }
}
