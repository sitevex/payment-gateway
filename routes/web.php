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
# Payphone
Route::get('/response', [PasarelaPagoController::class, 'payphoneTransResp'])->name('payphoneTransResp');
Route::post('/registro-confirmacion', [PasarelaPagoController::class, 'registroPayB1S'])->name('registroPagoB1S');
Route::post('/guardar-transaccion', [PasarelaPagoController::class, 'guardarTransaccionPasarela'])->name('guardarTransaccion');
# Datafast  
Route::post('/process-payment-datafast', [PasarelaPagoController::class, 'processCheckoutDatafast'])->name('processPaymentDatafast');
Route::get('/v1/checkouts', [PasarelaPagoController::class, 'transactionDetails'])->name('transactionDetails');

Route::get('/comprobante', [PasarelaPagoController::class, 'comprobateDetalle'])->name('comprobante');
# Login
Route::post('/logout-sap', [PasarelaPagoController::class, 'logoutSap'])->name('logoutSap');