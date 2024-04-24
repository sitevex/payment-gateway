<?php

namespace App\Http\Controllers;

use App\B1SLayer\ServiceLayer;
use App\Models\PasarelaPago;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

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

    public function payphoneTransResp(Request $request) {
        $response = $request->all();

        // Obtener los parámetros de la URL enviados por PayPhone
        $transaccion = $request->query('id');
        $client = $request->query('clientTransactionId');

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
        
        $result_array = json_decode($result, true);

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
        $pasarelaPago->authorizationCode = $result_array['authorizationCode'];
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

        $pasarelaPago->save();

        return redirect()->route('index')->with('success', 'La transacción se ha completado con éxito');
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
