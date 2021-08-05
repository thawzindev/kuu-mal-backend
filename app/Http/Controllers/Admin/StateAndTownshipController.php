<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Township;

class StateAndTownshipController extends Controller
{
    public function search($stateID)
    {
    	$data = Township::where('state_id', $stateID)->get();

    	return response()->json($data);
    }
}
