<?php

namespace App\Http\Controllers;

use App\B1SLayer\ServiceLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class PasarelaPagoController extends Controller
{
    protected $serviceLayer;

    function __construct(ServiceLayer $serviceLayer) 
    {
        $this->serviceLayer = $serviceLayer;
    }

    public function businessPartnersTwo(Request $request) 
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
