<?php

namespace App\Http\Controllers;

use App\B1SLayer\ServiceLayer;
use App\Models\PasarelaPago;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class PasarelaPagoController extends Controller
{
    protected $serviceLayer;

    function __construct(ServiceLayer $serviceLayer) 
    {
        $this->serviceLayer = $serviceLayer;
    }

    public function businessPartners(Request $request) 
    {
        // Obtener el valor de 'ruc' desde la solicitud formulario Login
        $ruc = $request->input('ruc');

        // Solicitud GET
        $resource = 'BusinessPartners';
        $select = '$select=CardCode,CardName,CardType,U_LA_PASWORD,FederalTaxID,Valid,GroupCode,Website';
        $filter = '$filter=FederalTaxID eq \'' . $ruc . '\' and Valid eq \'tYES\' and CardType eq \'cCustomer\'';

        $query = "$select&$filter";

        $businessPartners = $this->serviceLayer->getRequestQuery($resource, $query);
        // dd($businessPartners);
        // Hacer algo con los datos recibidos, por ejemplo, retornarlos como respuesta
        return response()->json($businessPartners);
    }

    public function listaPedido(Request $request) {
        $customerCode = $request->input('customerCode');
        
        // Solicitud GET
        $resource = '/sml.svc/ORDEN_CAB';
        $filter = '$filter=RUC eq \'' . $customerCode . '\'';
        //$orderby = '$orderby=CREATIONDATE desc';

        $query = "$filter";

        $listadoServicio = $this->serviceLayer->getRequestQuery($resource, $query);
        // dd($listadoServicio);
        return response()->json($listadoServicio);
    }

    public function obtenerDetallePedido(Request $request){
        $noPedido = $request->input('noPedido');
        
        $resource = '/sml.svc/ORDEN_LIN';
        $filter = '$filter=NO_PEDIDO eq ' .$noPedido;
       
        $query = "$filter";
        $detallePedido = $this->serviceLayer->getRequestQuery($resource, $query);
        // dd($detallePedido);
        return response()->json($detallePedido);
    }

    /* public function payphoneTransResp(Request $request) {
        $response = $request->all();

        // Obtener los parámetros de la URL enviados por PayPhone
        $transaccion = $request->query('id');
        $client = $request->query('clientTransactionId');

        // Verificar si ya existe un registro con la misma transacción
        $existingTransaction = PasarelaPago::where('transactionId', $transaccion)->first();

        // Si ya existe un registro con la misma transacción, no hacemos nada
        if ($existingTransaction) {
            return view('pages.pasarela_pago.comprobante');
        }

        // Preparar JSON de llamada
        $data_array = array(
            "id" => (int)$transaccion,
            "clientTxId" => $client
        );

        $data = json_encode($data_array);

        // Realizar la llamada a la API de Payphone
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pay.payphonetodoesposible.com/api/button/V2/Confirm");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw", 
                "Content-Type:application/json"
            ),
            CURLOPT_RETURNTRANSFER => 1
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        // return response()->json($result);
        $result_array = json_decode($result, true);
        // dd($result_array);
        // Verificar si la respuesta contiene un errorCode.
        if (isset($result_array['errorCode'])) {
            $errorMessage = $result_array['message'];
            return view('pages.pasarela_pago.comprobante', compact('errorMessage'));
        }

        $authorizationCode = null;
        if (isset($result_array['authorizationCode'])) {
            $authorizationCode = $result_array['authorizationCode'];
        }
        
        $pasarelaPago = new PasarelaPago();
        $pasarelaPago->email = $result_array['email'];
        $pasarelaPago->cardType = $result_array['cardType'];
        $pasarelaPago->bin = $result_array['bin'];
        $pasarelaPago->lastDigits = $result_array['lastDigits'];
        $pasarelaPago->deferredCode = $result_array['deferredCode'];
        $pasarelaPago->deferred = $result_array['deferred'];
        $pasarelaPago->cardBrandCode = $result_array['cardBrandCode'];
        $pasarelaPago->cardBrand = $result_array['cardBrand'];
        $pasarelaPago->amount = $result_array['amount'];
        $pasarelaPago->clientTransactionId = $result_array['clientTransactionId'];
        $pasarelaPago->phoneNumber = $result_array['phoneNumber'];
        $pasarelaPago->statusCode = $result_array['statusCode'];
        $pasarelaPago->transactionStatus = $result_array['transactionStatus'];
        $pasarelaPago->authorizationCode = $authorizationCode;
        $pasarelaPago->messageCode = $result_array['messageCode'];
        $pasarelaPago->transactionId = $result_array['transactionId'];
        $pasarelaPago->document = $result_array['document'];
        $pasarelaPago->currency = $result_array['currency'];
        $pasarelaPago->optionalParameter1 = $result_array['optionalParameter1'];
        $pasarelaPago->optionalParameter2 = $result_array['optionalParameter2'];
        $pasarelaPago->optionalParameter3 = $result_array['optionalParameter3'];
        $pasarelaPago->optionalParameter4 = $result_array['optionalParameter4'];
        $pasarelaPago->storeName = $result_array['storeName'];
        $pasarelaPago->date = $result_array['date'];
        $pasarelaPago->regionIso = $result_array['regionIso'];
        $pasarelaPago->transactionType = $result_array['transactionType'];
        $pasarelaPago->reference = $result_array['reference'];
        $pasarelaPago->tipoPasarela = 'payphone';
        
        $pasarelaPago->fill($result_array); // Esto asume que tus campos de la tabla de PasarelaPago coinciden con las claves de $result_array
    
        $pasarelaPago->save();
        return redirect()->route('comprobantePay', ['transactionId' => $pasarelaPago->transactionId]);
    } */
    
    // Obtener los parámetros de la URL enviados por PayPhone
    // $transaccion = $request->query('id');
    // $client = $request->query('clientTransactionId');

    public function payphoneTransResp(Request $request) {
        $response = $request->all();
        return view('pages.pasarela_pago.response', compact('response'));
    }

    public function guardarTransaccionPasarela(Request $request) {
        // Iniciar transacción de base de datos
        DB::beginTransaction();

        try {

            $authorizationCode = null;
            if ($request->has('authorizationCode')) {
                $authorizationCode = $request->input('authorizationCode');
            }

            // Guardar la transacción en la base de datos
            $pasarelaPago = new PasarelaPago();
            $tipoPasarela = $request->input('tipoPasarela');
            $pasarelaPago->tipoPasarela = $tipoPasarela;

            if ($tipoPasarela === 'payphone') {
                $pasarelaPago->email = $request->input('email');
                $pasarelaPago->cardType = $request->input('cardType');
                $pasarelaPago->bin = $request->input('bin');
                $pasarelaPago->lastDigits = $request->input('lastDigits');
                $pasarelaPago->deferredCode = $request->input('deferredCode');
                $pasarelaPago->deferred = $request->input('deferred');
                $pasarelaPago->cardBrandCode = $request->input('cardBrandCode');
                $pasarelaPago->cardBrand = $request->input('cardBrand');
                $pasarelaPago->amount = $request->input('amount');
                $pasarelaPago->clientTransactionId = $request->input('clientTransactionId');
                $pasarelaPago->phoneNumber = $request->input('phoneNumber');
                $pasarelaPago->statusCode = $request->input('statusCode');
                $pasarelaPago->transactionStatus = $request->input('transactionStatus');
                $pasarelaPago->authorizationCode = $authorizationCode;
                $pasarelaPago->messageCode = $request->input('messageCode');
                $pasarelaPago->transactionId = $request->input('transactionId');
                $pasarelaPago->document = $request->input('document');
                $pasarelaPago->currency = $request->input('currency');
                $pasarelaPago->optionalParameter1 = $request->input('optionalParameter1');
                $pasarelaPago->optionalParameter2 = $request->input('optionalParameter2');
                $pasarelaPago->optionalParameter3 = $request->input('optionalParameter3');
                $pasarelaPago->optionalParameter4 = $request->input('optionalParameter4');
                $pasarelaPago->storeName = $request->input('storeName');
                $pasarelaPago->date = $request->input('date');
                $pasarelaPago->regionIso = $request->input('regionIso');
                $pasarelaPago->transactionType = $request->input('transactionType');
                $pasarelaPago->reference = $request->input('reference');
                $pasarelaPago->tipoPasarela = 'payphone';
            } elseif ($tipoPasarela === 'otra_pasarela') {
                // Lógica para otro tipo de pasarela de pago
            } elseif ($tipoPasarela === 'tercer_tipo_pasarela') {
                // Lógica para tercer tipo de pasarela de pago
            }

            $pasarelaPago->save();

            // Confirmar la transacción de base de datos
            DB::commit();

            // Enviar una respuesta exitosa
            return response()->json(['message' => 'Transacción guardada con éxito'], 200);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Manejar el error adecuadamente
            return response()->json(['error' => 'Error al guardar la transacción: ' . $e->getMessage()], 500);
        }
        
    }

    public function comprobante($transactionId) {
        $pasarelaPago = PasarelaPago::findOrFail($transactionId);
        return view('pages.pasarela_pago.comprobante', compact('pasarelaPago'));
    }
    
    public function payphoneMessageError() {
        return view('pages.pasarela_pago.message_error');
    }

    public function logoutSap() {
        $response = $this->serviceLayer->logoutB1SLayer();

        // Verificar la respuesta y realizar acciones necesarias
        if ($response->successful()) {
            // Logout exitoso, realizar acciones adicionales si es necesario
            // Por ejemplo, limpiar la sesión local del usuario
            session()->flush();

            // Redireccionar al usuario a la página de inicio u otra página
            // return redirect()->route('indextwo')->with('success', '¡Sesión cerrada correctamente!');
        } else {
            // Logout no exitoso, manejar el error apropiadamente
            return back()->with('error', 'Error al cerrar sesión. Por favor, inténtelo de nuevo.');
        }
    }
}
