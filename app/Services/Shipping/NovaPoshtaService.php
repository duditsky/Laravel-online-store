<?php

namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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
        return [];
    }

    public function getCities($search)
    {
        $cacheKey = "np_cities_by_string_" . md5($search);
        return Cache::remember($cacheKey, 86400, function () use ($search) {
            return $this->apiRequest('Address', 'getCities', [
                'FindByString' => $search,
                'Limit' => '20',
            ]);
        });
    }

    public function getAllCitiesForCaching()
    {
        return Cache::remember("np_cities_all", 86400, function () {

            return $this->apiRequest('Address', 'getCities', [
                'Limit' => '10000', 
            ]);
        });
    }

    public function getWarehouses($cityRef)
    {
        return Cache::remember("np_warehouses_{$cityRef}", 86400, function () use ($cityRef) {
            return $this->apiRequest('Address', 'getWarehouses', [
                'CityRef' => $cityRef,
            ]);
        });
    }

    public function getCityNameByRef($cityRef)
    {
        $allCities = $this->getAllCitiesForCaching();
        foreach ($allCities as $city) {
            if ($city['Ref'] === $cityRef) {
                return $city['Description'];
            }
        }

        $data = $this->apiRequest('Address', 'getCities', [
            'Ref' => $cityRef,
        ]);

        return (!empty($data) && isset($data[0]['Description'])) ? $data[0]['Description'] : $cityRef;
    }
    public function getWarehouseNameByRef($cityRef, $warehouseRef)
    {
        $cachedWarehouses = $this->getWarehouses($cityRef); 
        foreach ($cachedWarehouses as $warehouse) {
            if ($warehouse['Ref'] === $warehouseRef) {
                return $warehouse['Description'];
            }
        }
        return "not found ($warehouseRef)";
    }
}
