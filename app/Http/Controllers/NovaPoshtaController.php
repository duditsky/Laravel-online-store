<?php

namespace App\Http\Controllers;

use App\Services\Shipping\NovaPoshtaService;
use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    private $novaPoshta;

    public function __construct(NovaPoshtaService $novaPoshta)
    {
        $this->novaPoshta = $novaPoshta;
    }

    public function getCities(Request $request)
    {
        $data = $this->novaPoshta->getCities($request->input('q'));
        
        return $data !== null 
            ? response()->json($data) 
            : response()->json(['error' => 'API Error'], 500);
    }

    public function getWarehouses(Request $request)
    {
        $data = $this->novaPoshta->getWarehouses($request->input('cityRef'));

        return $data !== null 
            ? response()->json($data) 
            : response()->json(['error' => 'API Error'], 500);
    }
}