<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AveController;

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
    return view('welcome');
});

Route::get('/aves', 
    [AveController::class, 'index'])->name('aves.aves');

Route::get('/listar', 
    [AveController::class, 'listar'])->name('aves.listar');

Route::get('/aves/agregar',
    [AveController::class, 'create'])->name('aves.create');

Route::get('/listar/{id}', 
    [AveController::class, 'actualizar'])->name('aves.actualizar');

Route::put('/listar/{id}/update',
    [AveController::class, 'update'])->name('aves.update');

Route::post('/aves',
    [AveController::class, 'guardar'])->name('aves.guardar');

Route::delete('/listar/{id}',
    [AveController::class, 'delete'])->name('aves.delete');

//FILTROS
Route::get('/aves/filtrar',
    [AveController::class, 'filtrar'])->name('aves.filtrar');

Route::get('/aves/filtrarLetra', 
    [AveController::class, 'filtrarPorLetra'])->name('aves.filtrarLetra');
