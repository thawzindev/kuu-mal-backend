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
	Route::middleware(['auth', 'superadmin'])->group(function () {
		Route::get('/', 'Admin\DashboardController@index')->name('admin.index');
		Route::resource('users', 'Admin\UserController', ['as' => 'admin']);

		Route::get('/tokens/create', function (Request $request) {
		    $token = App\Models\Volunteer::first()->createToken('login');

		    return ['token' => $token->plainTextToken];
		});

	});
});


