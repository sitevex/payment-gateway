<?php

namespace App\B1SLayer;

use Illuminate\Support\Facades\Http;

class ServiceLayer
{
    protected $baseUrl;
    protected $companyDB;
    protected $username;
    protected $password;
    protected $sessionId;

    public function __construct() 
    {
        $this->baseUrl = 'https://zcmayo.pa2.sap.topmanage.cloud/b1s/v1/';
        $this->companyDB = 'C370615_ZCMAYO_PRD';
        $this->username = 'tmcloud\\zcmayo-tecnologia';
        $this->password = '0v97VzW4U5ONm5fa';
        // Autenticar y obtener SessionId al crear la instancia de ServiceLayer
        $this->authenticate();
    }

    private function authenticate() 
    {
        $url = $this->baseUrl . 'Login';
        $data = [
            'CompanyDB' => $this->companyDB,
            'UserName' => $this->username,
            'Password' => $this->password,
        ];
        
        $response = Http::post($url, $data);
        // dd($response);
        if ($response->successful()) {
            $this->sessionId = $response['SessionId'];
        } else {
            $this->sessionId = null;
        }
    }

    /* public function authenticate($data = []) 
    {
        $url = $this->baseUrl . 'Login';
        $requestData = [
            'CompanyDB' => $this->companyDB,
            'UserName' => $this->username,
            'Password' => $this->password,
        ];

        // Verificar si $data es un string y convertirlo a un array si es necesario
        if (!empty($data) && is_string($data)) {
            parse_str($data, $parsedData);
            $data = $parsedData;
        }

        // Comprobar si $data es un array antes de combinarlo con $requestData
        if (is_array($data)) {
            $requestData = array_merge($requestData, $data);
        }
        
        $response = Http::post($url, $requestData);

        if ($response->successful()) {
            $this->sessionId = $response['SessionId'];
            return true;
        } else {
            $this->sessionId = null;
            return false;
        }
    } */

    public function getRequest($resource, $id = null) 
    {
        $url = $id ? "$resource/$id" : $resource;
        $response = Http::withBasicAuth($this->username, $this->password)
                    ->get($this->baseUrl.$url);
                    
        return $response->json();
    }

    public function getRequestQuery($resource, $query) 
    {
        $url = $this->baseUrl . $resource . '?' . $query;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Cookie' => 'B1SESSION=' . $this->sessionId,
        ])
        ->get($url);

        return $response->json();
    }

    function postRequest($resource, $data) 
    {
        $url = $this->baseUrl . $resource;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Cookie' => 'B1SESSION=' . $this->sessionId,
        ])
        ->post($url, $data);

        return $response->json();
    }
}