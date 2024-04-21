<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * Return a listing of cities the resource.
     */
    public function jsonList(Request $request) : JsonResponse
    {
        $state_id = $request->get('state_id', null);
        
        $items = [];
        if($state_id)
            $items = City::where('state_id', $state_id)->get();

        return response()->json($items);
    }
}
