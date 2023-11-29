<?php

use App\Http\Controllers\MunicipioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/ibge', 'MunicipioController@index')->name('ibge');
Route::get('/', [MunicipioController::class, 'index'])->name('ibge');


// Route::get('/get-municipios', 'MunicipioController@getMunicipios');
Route::get('/get-municipios', [MunicipioController::class, 'getMunicipios']);
