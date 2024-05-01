<?php

// use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\PasarelaPagoController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.pasarela_pago.index');
})->name('index');
Route::get('/businessPartners', [PasarelaPagoController::class, 'businessPartners'])->name('businessPartners');
Route::get('/lista-pedido', [PasarelaPagoController::class, 'listaPedido'])->name('listaPedido');
Route::get('/detalle-ordenes', [PasarelaPagoController::class, 'obtenerDetallePedido'])->name('detalleOrdenes');
Route::get('/response', [PasarelaPagoController::class, 'payphoneTransResp'])->name('payphoneTransResp');
Route::post('/registro-confirmacion', [PasarelaPagoController::class, 'registroPayB1S'])->name('registroPagoB1S');
Route::post('/guardar-transaccion', [PasarelaPagoController::class, 'guardarTransaccionPasarela'])->name('guardarTransaccion');
Route::get('/comprobante/{transactionId}', [PasarelaPagoController::class, 'comprobante'])->name('comprobantePay');
Route::post('/logout-sap', [PasarelaPagoController::class, 'logoutSap'])->name('logoutSap');

// Route::get('/message', [PasarelaPagoController::class, 'payphoneMessageError'])->name('payphoneMessage');
