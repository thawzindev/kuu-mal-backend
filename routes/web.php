<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/testing', function (Request $request) {

    \DB::beginTransaction();

	try {
	    \App\User::create([
	    	'name'	=> 'hi',
	    	'email'	=> rand().'@gmail.com',
	    	'phone'	=> rand(),
	    	'password'	=> bcrypt(rand()),
	    	'role' => 1
	    ]);

	    $k = \App\User::find(10212);

	    $k->name= 'ag ko';
	    $k->save();

	    \DB::commit();
	    // all good
	} catch (\Exception $e) {
		\Log::info($e);
	    \DB::rollback();
	    // something went wrong
	}
});
/**
 * CMS route.
 */
Route::prefix(config('app.admin_prefix'))->group(function () // sample 'admin'
{
	Auth::routes(['register' => false]);

	Route::get('states/{id}/townships', 'Admin\StateAndTownshipController@search');

	Route::middleware(['auth', 'superadmin'])->group(function () {
		Route::get('/', 'Admin\DashboardController@index')->name('admin.index');
		Route::resource('users', 'Admin\UserController', ['as' => 'admin']);

		Route::resource('volunteers', 'Admin\VolunteerController', ['as' => 'admin']);
		Route::get('volunteer/{volunteer}/update/status', 'Admin\VolunteerController@updateStatus')->name('admin.volunteers.status_update');

		Route::resource('help/requests', 'Admin\HelpRequestListController', ['as' => 'admin']);
		Route::get('help/requests/{request}/update/status', 'Admin\HelpRequestListController@updateStatus')->name('admin.requests.status_update');

		Route::resource('banned/ips', 'Admin\BanIpAddressController', ['as' => 'admin']);
		Route::get('ips/{ip}/ban', 'Admin\BanIpAddressController@banIp')->name('admin.ips.ban');


	});
});


