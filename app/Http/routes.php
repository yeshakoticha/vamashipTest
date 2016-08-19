<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Route::get('/', 'HomeController@index');

	Route::get('home', 'HomeController@index');
	Route::get('addressBook', 'AddressBookController@lists');
	Route::get('addAddress', 'AddressBookController@create');
	Route::post('saveAddr', 'AddressBookController@saveAddr');
	Route::get('editAddr/{id}', 'AddressBookController@show');
	Route::get('deleteAddr/{id}', 'AddressBookController@delete');
	Route::get('defaultFrom/{id}', 'AddressBookController@defaultFrom');
	Route::get('defaultTo/{id}', 'AddressBookController@defaultTo');
	Route::post('edit', 'AddressBookController@edit');

	Route::get('profile', 'AddressBookController@profile');
	Route::post('updateProfile', 'AddressBookController@updateProfile');

	Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	]);


	// API ROUTES
	Route::post('api/authenticate', 'APIController@authenticate'); 

	Route::group(['middleware' => 'jwt.auth'], function () {
		Route::get('api/getAddressList', 'APIController@getAddressList');
		Route::post('api/saveAddress', 'APIController@saveAddress');
		Route::post('api/editAddress', 'APIController@editAddress');
		Route::post('api/deleteAddress', 'APIController@deleteAddress');
		Route::post('api/logout', 'APIController@getLogout');
	});
