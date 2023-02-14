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

Route::get('/', [App\Http\Controllers\OperationController::class, 'index'])->name('dashboard');


Route::get("operations/filter", [App\Http\Controllers\OperationController::class, 'getOperationsWithFilters'])->name('operations.filter');
Route::resource("operations", App\Http\Controllers\OperationController::class);
Route::resource("categories", App\Http\Controllers\CategorieController::class);