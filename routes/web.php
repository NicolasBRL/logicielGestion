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

Route::get('/', [App\Http\Controllers\SiteInfoController::class, 'home'])->name('home');

/**
 * Utilisateur non connecté
 */
Route::group(['middleware' => ['guest']], function () {
    // Connexion
    Route::get('/login', [App\Http\Controllers\LoginController::class, 'show'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.connection');
});

/**
 * Utilisateur connecté
 */

Route::group(['middleware' => ['auth']], function () {

    // Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [App\Http\Controllers\OperationController::class, 'index'])->name('dashboard');

        Route::resource("operations", App\Http\Controllers\OperationController::class);
        Route::post("/operations/download-pdf", [App\Http\Controllers\OperationController::class, 'downloadOperationsPDF'])->name('operations.pdf');
        Route::resource("categories", App\Http\Controllers\CategorieController::class);
        Route::resource("utilisateurs", App\Http\Controllers\UserController::class);

        Route::group(['prefix' => '/configuration'], function () {
            Route::get('/page-builder', [App\Http\Controllers\SiteInfoController::class, 'pageBuilder'])->name('configuration.pageBuilder');
            Route::post('/page-builder', [App\Http\Controllers\SiteInfoController::class, 'pageBuilderSave'])->name('configuration.pageBuilder.save');
            Route::get('/', [App\Http\Controllers\SiteInfoController::class, 'index'])->name('configuration.index');
            Route::post('/', [App\Http\Controllers\SiteInfoController::class, 'update'])->name('configuration.update');
            Route::post('/upload_image', [App\Http\Controllers\SiteInfoController::class, 'uploadImages'])->name('configuration.uploadImages');
        });
    });

    // Déconnexion
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});
