<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationController extends Controller
{
    /**
     * Populate the location autocomplete. Called with every user keystroke
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $location = $request->input('term'); // specific from jQuery autocomplete

        $locations = Location::select('id as value', 'city as label')
            ->where('city', 'like', '%' . $location . '%')
            ->limit(10)
            ->get();

        return response()->json($locations);
    }

}
