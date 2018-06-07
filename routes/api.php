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

Route::post('/login', 'Api\LoginController@login');
Route::post('/register', 'Api\RegisterController@register');

Route::group(['middleware' => 'jwt.auth'], function () {

	Route::post('/logout', 'Api\LoginController@logout');

	// Api Resoruces
	Route::namespace('Group')->group(function () {
		Route::apiResource('groups', 'GroupController');
		Route::apiResource('groups.stops', 'GroupStopController');
	});

});