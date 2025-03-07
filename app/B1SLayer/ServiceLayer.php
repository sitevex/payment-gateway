<?php

namespace App\B1SLayer;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ServiceLayer
{
    protected $baseUrl;
    protected $companyDB;
    protected $username;
    protected $password;
    protected $sessionId;
    public const PAYPHONE_TOKEN = 'oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw';

    public function __construct() 
    {
        // DEV
        //$this->baseUrl = '';
        //$this->companyDB = '';
        //$this->username = '';
        //$this->password = '';

        // PROD
        $this->baseUrl = '';
        $this->companyDB = '';
        $this->username = '';
        $this->password = '';
        
        // Autenticar y obtener SessionId al crear la instancia de ServiceLayer.
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
        if ($response->successful()) {
            $this->sessionId = $response['SessionId'];
        } else {
            $this->sessionId = null;
        }
    }

    public function getRequest($resource, $id = null) 
    {
        $url = $id ? "$resource/$id" : $resource;
        // $cacheKey = $url;

        // return Cache::remember($cacheKey, 3600, function () use ($url) {
            $response = Http::withBasicAuth($this->username, $this->password)
                        ->get($this->baseUrl.$url);
                        
            return $response->json();
        // });
    }

    public function getRequestQuery($resource, $query) 
    {
        $url = $this->baseUrl . $resource . '?' . $query;
        // $cacheKey = md5($url);

        // return Cache::remember($cacheKey, 3600, function () use ($url) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Cookie' => 'B1SESSION=' . $this->sessionId,
            ])
            ->get($url);
    
            return $response->json();
        // });
    }

    public function postRequest($resource, $data) 
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

    public function logoutB1SLayer() {
        $url = $this->baseUrl . 'Logout';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Cookie' => 'B1SESSION=' . $this->sessionId,
        ])
        ->post($url);

        return $response;
    }
}