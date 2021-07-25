<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Http\Resources\VolunteerListResource;

class VolunteerController extends Controller
{
    public function index()
    {
    	$data = Volunteer::active()->with('township')->paginate();

    	return VolunteerListResource::collection($data);
    }
}
