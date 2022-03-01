<?php

use App\Http\Controllers\Login\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('register', function () {
    return abort('403', 'No Permitido');
})->name('register');

//Route::view('acceder', 'welcome')->name('acceder')->name('login');
Auth::routes();
/* Route::post('login', [LoginController::class, 'login'])->name('acceder');
Route::post('salir', [LoginController::class, 'cerrarSesion'])->name('salir'); */
