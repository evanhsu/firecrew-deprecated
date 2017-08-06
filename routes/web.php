<?php

use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', array('as' => 'map', 'uses' => 'MapController@getMap'));
Route::get('/home', 'HomeController@index');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {

// STATUS
    // A "Status" is an object that belongs to 'Helicopter' or 'Crew'.
    // A new Status is created when a "Status Update" form is submitted.
    // A Status cannot be deleted or edited, only superceded. This maintains a history log of statuses.
    // Route::get('/status/{id}',	array('as' => 'show_status', 		'uses' => 'StatusController@show' ));
    Route::post('/status',      array('as' => 'create_status',      'uses' => 'StatusController@store' ));
    Route::get('/status/all', 	array('as' => 'current_statuses',	'uses' => 'StatusController@currentForAllResources' ));

// AIRCRAFT
    Route::get('/aircraft',							array('as' => 'aircraft_index', 				'uses' => 'AircraftController@index'));
    Route::get('/aircraft/{tailnumber}/status',		array('as' => 'current_status_for_aircraft', 	'uses' => 'AircraftController@showCurrentStatus'));
    Route::get('/aircraft/{tailnumber}/update',		array('as' => 'new_status_for_aircraft', 		'uses' => 'AircraftController@newStatus'));
    Route::post('/aircraft/{tailnumber}/release', 	array('as' => 'release_aircraft', 				'uses' => 'AircraftController@releaseFromCrew'));
    Route::post('/aircraft/{tailnumber}/destroy',  	array('as' => 'destroy_aircraft',   			'uses' => 'AircraftController@destroy'));


// CREWS
    Route::get('/crew',                	array('as' => 'crews_index',    				'uses' => 'CrewController@index'));
    Route::get('/crew/new',            	array('as' => 'new_crew',       				'uses' => 'CrewController@create'));
    Route::post('/crew/new',           	array('as' => 'store_crew',     				'uses' => 'CrewController@store'));
    Route::get('/crew/{id}',       		array('as' => 'crew',       					'uses' => 'CrewController@show'));
    Route::post('/crew/{id}',			array('as' => 'update_crew',					'uses' => 'CrewController@update'));
    Route::get('/crew/{id}/update',     array('as' => 'new_status_for_crew',    		'uses' => 'CrewController@newStatus'));
    Route::get('/crew/{id}/post',       array('as' => 'status_form_selector_for_crew',  'uses' => 'CrewController@redirectToStatusUpdate'));
    Route::get('/crew/{id}/status',     array('as' => 'current_status_for_crew',		'uses' => 'CrewController@showCurrentStatus'));
    Route::get('/crew/{id}/identity',  	array('as' => 'edit_crew',  					'uses' => 'CrewController@edit'));
    Route::get('/crew/{id}/accounts',  	array('as' => 'users_for_crew',					'uses' => 'CrewController@accounts'));
    Route::get( '/crew/{id}/accounts/new', array('as' => 'new_user_for_crew',  			'uses' => 'Auth\AuthController@getRegister'));
    Route::post('/crew/{id}/destroy',  	array('as' => 'destroy_crew',   				'uses' => 'CrewController@destroy'));


// ACCOUNTS
    Route::get('/accounts',					array('as' => 'users_index',	'uses' => 'Auth\AuthController@index'));
    Route::post('/accounts/new',			array('as' => 'register_user',	'uses' => 'Auth\AuthController@postRegister'));
    Route::get('/accounts/{id}',			array('as' => 'edit_user',		'uses' => 'Auth\AuthController@edit'));
    Route::post('/accounts/{id}',			array('as' => 'update_user',	'uses' => 'Auth\AuthController@update'));
    Route::post('/accounts/{id}/destroy',	array('as' => 'destroy_user',	'uses' => 'Auth\AuthController@destroy'));

});

 // These routes should be in the 'auth' group, but have been moved out for development
// INVENTORY
Route::get('/crew/{crewId}/inventory/{anything?}', 'PagesController@inventory');
