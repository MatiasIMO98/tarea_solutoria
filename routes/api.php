<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicadorController;
use App\Models\Indicador;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/token', [IndicadorController::class, 'obtenerToken']);

Route::get('/show', [IndicadorController::class, 'show'])->name('mostrar');
Route::post('/destroy', [IndicadorController::class, 'destroy'])->name('borrar');
Route::post('/create', [IndicadorController::class, 'create'])->name('crear');
Route::post('/edit', [IndicadorController::class, 'edit'])->name('guardar');

Route::get('/getTableData', [IndicadorController::class, 'getTableData'])->name('getTableData');

Route::get('/pagination', function() {
    $itemsPerPage = 10;
    return Indicador::paginate($itemsPerPage);
    
  })->name('pagination');