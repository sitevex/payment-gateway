<?php

use App\Http\Controllers\SeguridadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login.index');
});

Route::get('/index', [SeguridadController::class, 'index'])->name('index');
