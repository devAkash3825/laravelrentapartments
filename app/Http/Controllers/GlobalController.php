<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class GlobalController extends Controller
{
    //


    public function getCities(Request $request)
    {
        $state_id = $request->state_id;
        $cities = City::where('StateId', $state_id)->get();
        return response()->json($cities);
    }

}
