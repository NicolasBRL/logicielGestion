<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltersOperationsRequest;
use App\Http\Requests\StoreOperationRequest;
use App\Models\Categorie;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class OperationController extends Controller
{
    /**
     * Affiche la vue de gestion des comptes
     * 
     */
    public function index(FiltersOperationsRequest $request)
    {
        if ($request->has('filtreOperations')) {

            list($operations, $filtersList) = $this->getFilteredOperations($request);
            $totalOpeFiltrer = Operation::calculOperationsFiltrer($operations);
            $categories = Categorie::all();

            return view('dashboard', compact('operations', 'categories', 'filtersList', 'totalOpeFiltrer'));
        } else {
            $operations = Operation::orderBy('created_at', 'DESC')->paginate(15);
            $categories = Categorie::all();
            return view('dashboard', compact('operations', 'categories'));
        }
    }

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

        if ($operation) {
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
    public function destroy(Request $request)
    {
        Operation::find($request->id)->delete();
        return redirect(route('dashboard'))->with('success', 'Opération supprimée !');
    }


    /**
     * Téléchargement d'un fichier pdf
     * 
     */
    public function downloadOperationsPDF(Request $request)
    {
        if ($request->has('filtreOperationsPDF')) {
            list($operations, $filtersList) = $this->getFilteredOperations($request);

            $totalOpeFiltrer = Operation::calculOperationsFiltrer($operations);
        } else {
            $operations = Operation::orderBy('created_at', 'DESC')->get();
            $totalOpeFiltrer = Operation::calculOperationsFiltrer($operations);
        }


        $pdf = PDF::loadView('pdf.operationslist', array(
            'operations' => $operations, 
            'totalOpeFiltrer' => $totalOpeFiltrer, 
            'filtersList' => (isset($filtersList)) ? $this->formatterFiltersPDF($filtersList) : null
        ));

        return $pdf->download('liste-operations.pdf');
    }

    private function getFilteredOperations($request)
    {
        $operationsFiltered = Operation::query();

        if ($request->filled('categorieFiltre')) {
            $operationsFiltered->whereIn('categorieId', $request->categorieFiltre);
        }

        if ($request->filled('filterFirstDate')) {
            $firstDate = Carbon::createFromFormat('d/m/Y',  $request->filterFirstDate)->format('Y-m-d H:i:s');
            if ($request->filled('filterSecondDate')) $secondDate = Carbon::createFromFormat('d/m/Y',  $request->filterSecondDate)->format('Y-m-d H:i:s');

            if ($request->filtreDateType === 'before') {
                $operationsFiltered->whereDate('date', '<', $firstDate);
            } else if ($request->filtreDateType === 'between') {
                $operationsFiltered->whereBetween('date', [$firstDate, $secondDate]);
            } else {
                $operationsFiltered->whereDate('date', '>=', $firstDate);
            }
        }

        return array(
            $operationsFiltered->get(),
            [
                'categories' => $request->categorieFiltre,
                'filtreDateType' => $request->filtreDateType,
                'filterFirstDate' => $request->filterFirstDate,
                'filterSecondDate' => $request->filterSecondDate,
            ]
        );
    }

    private function formatterFiltersPDF($filters)
    {
        $formatterTxt = '';
        if($filters['categories']){
            $formatterTxt = $formatterTxt.'Catégories : '.Categorie::getNomCategories($filters['categories']).'</br>';
        }

        if($filters['filterFirstDate']){
            $firstDate = $filters['filterFirstDate'];
            if ($filters['filterSecondDate']) $secondDate = $filters['filterSecondDate'];
            
            if($filters['filtreDateType'] === 'before'){
                $formatterTxt = $formatterTxt.' Avant le '.$firstDate;
            }elseif($filters['filtreDateType'] === 'between'){
                $formatterTxt = $formatterTxt.' Entre le '.$firstDate.' et le '.$secondDate;
            }else{
                $formatterTxt = $formatterTxt.' Après le '.$firstDate;
            }
        }

        return $formatterTxt;
    }
}
