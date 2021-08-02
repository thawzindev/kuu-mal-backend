<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Http\Resources\VolunteerListResource;
use Validator;
use App\Filters\VolunteerFilter;

class VolunteerController extends Controller
{

    public function getProfile()
    {
        $user = auth()->user();

        return response()->json(['data' => $user]);
    }

    public function index(VolunteerFilter $filter)
    {
    	$data = Volunteer::filter($filter)->active()->with('township')->paginate(10);

    	return VolunteerListResource::collection($data);
    }

    public function create(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name'       => 'required|max:30',
            'phone'       => 'required|unique:volunteers|max:11',
            'password'       => 'required|max:12',
            'state_id'       => 'required',
            'township_id'       => 'required',
            'activities'    => 'required|max:255',
    	]);

    	if ($validator->fails()) {
    		return response(['message' => $validator->errors()->first()], 422);
    	}

    	$data = $request->all();
    	$data['password'] = bcrypt($request->password);

    	Volunteer::create($data);

    	return response()->json(['message' => 'Success']);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        auth()->user()->update($data);

        return response()->json(['message' => 'Success']);
    }
}
