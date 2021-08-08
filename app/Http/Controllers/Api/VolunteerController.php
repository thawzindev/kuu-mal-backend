<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Http\Resources\VolunteerListResource;
use Validator;
use App\Filters\VolunteerFilter;
use App\Http\Requests\VolunteerUpdateRequest;
use App\Http\Resources\VolunteerProfileResource;

class VolunteerController extends Controller
{

    public function getProfile()
    {
        $user = auth()->user();

        return new VolunteerProfileResource($user);
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
            'phone'       => 'required|unique:volunteers|max:30',
            'password'       => 'required|max:30',
            'state_id'       => 'required',
            'township_id'       => 'required',
            'activities'    => 'required|max:255',
    	]);

    	if ($validator->fails()) {
    		return response(['message' => $validator->errors()->first()], 422);
    	}

    	$data = $request->all();
    	$data['password'] = bcrypt($request->password);
        $data['user_agent'] = $request->header('User-Agent');
        $data['ip_address'] = getIp();

    	Volunteer::create($data);

    	return response()->json(['message' => 'Success']);
    }

    public function update(VolunteerUpdateRequest $request)
    {
        $validated = $request->validated();

        $volunteer = auth()->user();

        $diffTime = time() - $volunteer->updated_at->timestamp;

        if ($diffTime < 1800 ) {
            return response()->json(['message' => "update မပြုလုပ်နိုင်သေးပါ။ နောက် နာရီဝက်မှ ပြန်လည် update လုပ်ပါ။"], 422);
        }    


        $data = $request->all();
        $volunteer->update($data);

        return response()->json(['message' => 'Success']);
    }
}
