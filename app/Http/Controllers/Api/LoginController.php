<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Volunteer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {   
    	$validator = Validator::make($request->all(), [
            'phone'       => 'required',
            'password'    => 'required',
    	]);

    	if ($validator->fails()) {
    		return response(['message' => $validator->errors()->first()], 422);
    	}

        $volunteer = Volunteer::where('phone', $request->phone)->first();
        // $volunteer = \App\User::first();

        if (!$volunteer) {
            return response()->json(['message' => 'အကောင့်ရှာမတွေ့ပါ။'], 422);
        }

        if (Hash::check($request->password, $volunteer->password)) {

            $token = JWTAuth::fromUser($volunteer);

            return response()->json([
                'id'    => $volunteer->id,
                'name'  => $volunteer->name,
                'phone' => $volunteer->phone,
                'access_token'  => $token,
            ]);

        }


		return response()->json(['message' => 'လျှို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။'], 422);

    }
}
