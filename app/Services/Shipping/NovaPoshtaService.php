<?php

namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NovaPoshtaService
{
    private $apiKey;
    private $apiUrl = 'https://api.novaposhta.ua/v2.0/json/';

    public function __construct()
    {
        $this->apiKey = config('nova.key');
    }

    private function apiRequest($model, $method, $properties)
    {
        $response = Http::post($this->apiUrl, [
            'apiKey' => $this->apiKey,
            'modelName' => $model,
            'calledMethod' => $method,
            'methodProperties' => $properties,
        ]);

        if ($response->successful()) {
            return $response->json('data') ?? [];
        }

        Log::error("Nova Poshta API Error ($method): " . $response->body());
        return null;
    }

    public function getCities($search)
    {
        return $this->apiRequest('Address', 'getCities', [
            'FindByString' => $search,
            'Limit' => '20',
        ]);
    }

    public function getWarehouses($cityRef)
    {
        return $this->apiRequest('Address', 'getWarehouses', [
            'CityRef' => $cityRef,
        ]);
    }

    public function getCityNameByRef($cityRef)
    {
        $data = $this->apiRequest('Address', 'getCities', [
            'Ref' => $cityRef,
        ]);

        return (!empty($data)) ? $data[0]['Description'] : $cityRef;
    }
    public function getWarehouseNameByRef($cityRef, $warehouseRef)
    {
        $data = $this->apiRequest('Address', 'getWarehouses', [
            'CityRef' => $cityRef,
            'Ref'     => $warehouseRef,
        ]);

        if (!empty($data) && isset($data[0]['Description'])) {
            return $data[0]['Description'];
        }

        return "wa ($warehouseRef)";
    }
}
