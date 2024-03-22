<?php

namespace App\Http\Controllers;

use App\B1SLayer\ServiceLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class SeguridadController extends Controller
{
    protected $serviceLayer;

    function __construct(ServiceLayer $serviceLayer) 
    {
        $this->serviceLayer = $serviceLayer;
    }

    public function index(Request $request) 
    {
        // Obtener el valor de 'ruc' desde la solicitud
        $ruc = $request->input('ruc');

        // Solicitud GET
        $resource = 'BusinessPartners';
        $select = '$select=CardCode,CardName,CardType,U_LA_PASWORD,FederalTaxID,Valid,GroupCode,Website';
        $filter = '$filter=FederalTaxID eq \'' . $ruc . '\' and Valid eq \'tYES\' and CardType eq \'cCustomer\'';

        $query = "$select&$filter";

        $businessPartners = $this->serviceLayer->getRequestQuery($resource, $query);
        // dd($businessPartners);
        // Hacer algo con los datos recibidos, por ejemplo, retornarlos como respuesta
        // return response()->json($businessPartners);
        
        // Convertir los datos a JSON
        // $businessPartnersJson = json_encode($businessPartners);
        // return View::make('pages.pedido.index_two', ['businessPartnersJson' => $businessPartnersJson]);
        // $businessPartnersJson = response()->json($businessPartners);
        // return View::make('pages.pedido.index_two');

        // Convertir los datos a JSON
        // $businessPartnersJson = json_encode($businessPartners);

        // Redirigir a una nueva vista Blade con los datos
        return Redirect::route('pages.pedido.index_two')->with('businessPartners', $businessPartners);
    }

}
