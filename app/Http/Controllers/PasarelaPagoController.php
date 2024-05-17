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

    public function payphoneTransResp(Request $request) {
        $response = $request->all();
        return view('pages.pasarela_pago.response', compact('response'));
    }

    public function processCheckoutDatafast(Request $request) {

        $entityId = '8a829418533cf31d01533d06f2ee06fa';
        $amount = $request->amount;
        $paymentType = 'DB';
        
        $url = "https://eu-test.oppwa.com/v1/checkouts?entityId={$entityId}&amount={$amount}&paymentType={$paymentType}";
        
        $headers = [
            'Authorization' => 'Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA==',
        ];

        // Realizar la solicitud HTTP
        try {
            $response = Http::withHeaders($headers)->post($url);
            
            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                // $responseData = $response->json();
                // Guardar el id en la sesión
                // session(['checkoutId' => $responseData['id']]);
                // return redirect()->back();

                return $response->json();
            } else {
                return response()->json(['error' => 'Hubo un problema al procesar la solicitud'], $response->status());
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción
            return response()->json(['error' => 'Hubo un problema al procesar la solicitud'], 500);
        }
        
    }

    public function transactionDetails(Request $request, $checkoutId) {
        // return response()->json($request->resourcePath);
        // dd($request);
        // dd($request); 
        $url = "https://teAst.oppwa.com/{$request->resourcePath}"; 
        $url .= "?entityId=8a829418533cf31d01533d06f2ee06fa"; // Asegúrate de tener el entityId correcto
        
        // return $url;
        $headers = [
            'Authorization:Bearer OGE4Mjk0MTg1MzNjZjMxZDAxNTMzZDA2ZmQwNDA3NDh8WHQ3RjIyUUVOWA=='
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Esto debería ser true en producción
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)){
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }

    public function registroPayB1S(Request $request){
        $codigoEstado = $request->input('statusCode');
        $amount = $request->input('amount');
        $amountFormat = number_format($amount / 100, 2);

        $dataTransaction = [
            'Code' => $request->input('document'),
            'Name' => $request->input('storeName'),
            'U_email' => $request->input('email'),
            'U_cardType' => $request->input('cardType'),
            'U_bin' => $request->input('bin'),
            'U_lastDigits' => $request->input('lastDigits'),
            'U_deferredCode' => $request->input('deferredCode'),
            'U_deferred' => $request->input('deferred'),
            'U_cardBrandCode' => $request->input('cardBrandCode'),
            'U_cardBrand' => $request->input('cardBrand'),
            'U_clientTransactionId' => $request->input('clientTransactionId'),
            'U_phoneNumber' => $request->input('phoneNumber'),
            'U_statusCode' => $request->input('statusCode'),
            'U_transactionStatus' => $request->input('transactionStatus'),
            'U_authorizationCode' => $request->input('authorizationCode'),
            'U_messageCode' => $request->input('messageCode'),
            'U_transactionId' => $request->input('transactionId'),
            'U_document' => $request->input('document'),
            'U_currency' => $request->input('currency'),
            'U_optionalParameter1' => $request->input('optionalParameter1'),
            'U_optionalParameter2' => $request->input('optionalParameter2'),
            'U_optionalParameter3' => $request->input('optionalParameter3'),
            'U_optionalParameter4' => $request->input('optionalParameter4'),
            'U_storeName' => $request->input('storeName'),
            'U_date' => $request->input('date'),
            'U_regionIso' => $request->input('regionIso'),
            'U_transactionType' => $request->input('transactionType'),
            'U_reference' => $request->input('reference'),
            'U_tipoPasarela' => $request->input('tipoPasarela'),
            // 'U_codigoSap' => $request->input('codigoSap'),
            'U_amount' => $amountFormat
        ];

        if ($codigoEstado === 3) {
            $createdTransaction = $this->serviceLayer->postRequest('pasarelaPagos', $dataTransaction);
            return response()->json($createdTransaction);
        } else {
            return response()->json(['message' => 'La transacción fue cancelada'], 200);
        }
    }

    public function guardarTransaccionPasarela(Request $request) {
        // Iniciar transacción de base de datos
        DB::beginTransaction();

        try {
            $transaccionId = $request->input('transactionId');
            // Verificar si ya existe un registro con la misma transacción
            $existingTransaction = PasarelaPago::where('transactionId', $transaccionId)->first();
            // Si ya existe un registro con la misma transacción, no hacemos nada
            if ($existingTransaction) {
                return response()->json(['message' => 'Transacción guardada con éxito'], 200);
            }

            $authorizationCode = null;
            if ($request->has('authorizationCode')) {
                $authorizationCode = $request->input('authorizationCode');
            }

            // Guardar la transacción en la base de datos
            $pasarelaPago = new PasarelaPago();
            $tipoPasarela = $request->input('tipoPasarela');
            $pasarelaPago->tipoPasarela = $tipoPasarela;
            $amount = $request->input('amount');
            $amountFormat = number_format($amount / 100, 2);
            
            if ($tipoPasarela === 'payphone') {
                $pasarelaPago->email = $request->input('email');
                $pasarelaPago->cardType = $request->input('cardType');
                $pasarelaPago->bin = $request->input('bin');
                $pasarelaPago->lastDigits = $request->input('lastDigits');
                $pasarelaPago->deferredCode = $request->input('deferredCode');
                $pasarelaPago->deferred = $request->input('deferred');
                $pasarelaPago->cardBrandCode = $request->input('cardBrandCode');
                $pasarelaPago->cardBrand = $request->input('cardBrand');
                $pasarelaPago->amount = $amountFormat;
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
                $pasarelaPago->codigoSap = $request->input('codigoSap');
                $pasarelaPago->tipoPasarela = 'payphone';
            } elseif ($tipoPasarela === 'otra_pasarela') {
                // Lógica para otro tipo de pasarela de pago
            } elseif ($tipoPasarela === 'tercer_tipo_pasarela') {
                // Lógica para tercer tipo de pasarela de pago
            }

            // $pasarelaPago->fill($result_array);
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

    public function comprobateDetalle(Request $request) {
        return view('pages.pasarela_pago.comprobante');
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
