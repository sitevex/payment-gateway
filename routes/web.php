<?php

use App\Http\Controllers\SeguridadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login.index');
});

Route::get('/index', [SeguridadController::class, 'index'])->name('index');
Route::get('/vista/businessPartners', function () {
    return view('pages.pedido.index_two');
})->name('pages.pedido.index_two');

Route::get('/businessPartners', [SeguridadController::class, 'businessPartners'])->name('businessPartners');
Route::get('/pedido', function () {
    return view('pages.pedido.index');
});
