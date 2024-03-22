<?php

namespace App\Http\Controllers;

use App\B1SLayer\ServiceLayer;
use Illuminate\Http\Request;

class SeguridadController extends Controller
{
    protected $serviceLayer;

    function __construct(ServiceLayer $serviceLayer) 
    {
        $this->serviceLayer = $serviceLayer;
    }

    function index(Request $request) 
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
        return response()->json($businessPartners);
    }
}
