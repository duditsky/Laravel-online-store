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
        $search = $request->input('q');

        if (mb_strlen($search) < 2) {
            return response()->json([]);
        }

        $data = $this->novaPoshta->getCities($search);

        return response()->json($data);
    }

    public function getWarehouses(Request $request)
    {
        $cityRef = $request->input('cityRef');
        $search = $request->input('q');

        if (!$cityRef) {
            return response()->json([]);
        }

        $data = $this->novaPoshta->getWarehouses($cityRef);

        if ($search && !empty($data)) {
            $data = array_values(array_filter($data, function ($item) use ($search) {
                return mb_stripos($item['Description'], $search) !== false;
            }));
        }

        return response()->json($data);
    }
}
