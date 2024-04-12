<?php

// use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\PasarelaPagoController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('pages.login.index');
});

Route::get('/index', [SeguridadController::class, 'index'])->name('index');
Route::get('/vista/businessPartners', function () {
    return view('pages.pedido.index_two');
})->name('pages.pedido.index_two');

Route::get('/businessPartners', [SeguridadController::class, 'businessPartners'])->name('businessPartners');
Route::get('/pedido', function () {
    return view('pages.pedido.index');
}); */



Route::get('/index', function () {
    return view('pages.pasarela_pago.index');
})->name('index');
Route::get('/businessPartnerstwo', [PasarelaPagoController::class, 'businessPartnersTwo'])->name('businessPartners');
Route::get('/lista-pedido', [PasarelaPagoController::class, 'listaPedido'])->name('listaPedido');
Route::post('/logout-sap', [PasarelaPagoController::class, 'logoutSap'])->name('logoutSap');
Route::get('/detalle-ordenes', [PasarelaPagoController::class, 'obtenerDetallePedido'])->name('detalle-ordenes');
