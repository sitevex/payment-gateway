<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login.index');
});

Route::get('/pedido', function () {
    return view('pages.pedido.index');
});