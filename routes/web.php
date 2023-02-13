<?php

use App\Models\Categorie;
use App\Models\Operation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $operations = Operation::orderBy('created_at', 'DESC')->paginate(15);
    $categories = Categorie::all();
    return view('dashboard', compact('operations', 'categories'));
})->name('dashboard');


Route::resource("operations", App\Http\Controllers\OperationController::class);
Route::resource("categories", App\Http\Controllers\CategorieController::class);