<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Township;
use App\Filters\TownshipFilter;

class StateAndTownshipController extends Controller
{
	public function getState()
    {
    	$data = State::select('id', 'name_mm as name')->get();
    	return response()->json(['data'	=> $data]);
    }

    public function getTownship(TownshipFilter $filter)
    {
    	$data = Township::filter($filter)->select('id', 'name_mm as name')->get();
    	return response()->json(['data'	=> $data]);
    }

}
