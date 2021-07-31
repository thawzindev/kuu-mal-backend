<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HelpFormRequest;
use App\Http\Resources\HelpRequestListResource;
use App\Filters\HelpRequestListFilter;
use Validator;
use App\Models\HelpRequestList;

class HelpController extends Controller
{
    public function requestForm(Request $request)
    {	
    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'township_id'   => 'required',
            'activities'    => 'required',
            'address'       => 'required'
    	]);

    	if ($validator->fails()) {
    		return response(['errors' => $validator->errors()->first()], 422);
    	}

    	$data = $request->all();
    	$data['uuid'] = help_uuid();
        $data['user_agent'] = $request->header('User-Agent');
        $data['ip_address'] = getIp();

    	HelpRequestList::create($data);

    	return response()->json(['message' => 'လုပ်ဆောင်ချက်အောင်မြင်ပါသည်။']);

    }

    public function requestList(Request $request, HelpRequestListFilter $filter)
    {
        $data = HelpRequestList::filter($filter)->notComplete()
                        ->with('township')
                        ->orderBy('created_at', 'desc')
                        ->paginate();

        return HelpRequestListResource::collection($data);
    }
}
