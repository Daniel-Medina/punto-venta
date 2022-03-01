<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\Asignar;
use App\Http\Livewire\Cashout;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Permisos;
use App\Http\Livewire\Pos;
use App\Http\Livewire\Products;
use App\Http\Livewire\Reports;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;

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
    return redirect()->route('pos');
})->name('inicio');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Middleware auth
Route::middleware(['auth'])->group(function() {
    //Rutas de la app
    Route::get('categorias', Categories::class)->name('categories');
    Route::get('productos', Products::class)->name('products');
    Route::get('monedas', Coins::class)->name('denominations');
    Route::get('venta', Pos::class)->name('pos');
    Route::get('roles', Roles::class)->name('roles');
    Route::get('permisos', Permisos::class)->name('permissions');
    Route::get('asignar', Asignar::class)->name('asignar');
    Route::get('usuarios', Users::class)->name('users');
    Route::get('administrar', Cashout::class)->name('cashout');
    Route::get('reportes', Reports::class)->name('reports');


    //Reportes PDF
    Route::get('reporte/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF'])->name('generarPDF');
    Route::get('reporte/pdf/{user}/{type}', [ExportController::class, 'reportPDF'])->name('generarPDF');
    //Reportes en Excel
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportExcel']);
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reportExcel']);

});