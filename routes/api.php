<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

	Route::post('volunteer/login', 'Api\LoginController@login');
	Route::get('volunteers', 'Api\VolunteerController@index');
	Route::post('help/request', 'Api\HelpController@requestForm');
	Route::get('townships', 'Api\StateAndTownshipController@getTownship');
	Route::get('states', 'Api\StateAndTownshipController@getState');
	Route::get('help/requests/list', 'Api\HelpController@requestList');

