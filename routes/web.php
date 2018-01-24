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



// AIRCRAFT
    Route::get('/aircraft',							array('as' => 'aircraft_index', 				'uses' => 'AircraftController@index'));
    Route::get('/aircraft/{tailnumber}/status',		array('as' => 'current_status_for_aircraft', 	'uses' => 'AircraftController@showCurrentStatus'));
    Route::get('/aircraft/{tailnumber}/update',		array('as' => 'new_status_for_aircraft', 		'uses' => 'AircraftController@newStatus'));
    Route::post('/aircraft/{tailnumber}/release', 	array('as' => 'release_aircraft', 				'uses' => 'AircraftController@releaseFromCrew'));
    Route::post('/aircraft/{tailnumber}/destroy',  	array('as' => 'destroy_aircraft',   			'uses' => 'AircraftController@destroy'));


// CREWS
    Route::prefix('crew')->namespace('Crew')->group(function () {
        Route::get('/',                 array('as' => 'crews_index',    'uses' => 'CrewController@index'));
        Route::post('/',                array('as' => 'store_crew',     'uses' => 'CrewController@store'));
        Route::get('/new',              array('as' => 'new_crew',       'uses' => 'CrewController@create'));
        Route::get('/{crewId}',         array('as' => 'crew',           'uses' => 'CrewController@show'));
        Route::get('/{crewId}/identity',array('as' => 'edit_crew',      'uses' => 'CrewController@edit'));
        Route::post('/{crewId}',        array('as' => 'update_crew',    'uses' => 'CrewController@update')); // TODO: Update method to PATCH

        Route::prefix('{crewId}/status')->group(function () {
            Route::get('/',         array('as' => 'current_status_for_crew',        'uses' => 'CrewStatusController@showCurrentStatus'));
            Route::get('/update',   array('as' => 'new_status_for_crew',            'uses' => 'CrewStatusController@newStatus'));
            Route::get('/router',   array('as' => 'status_form_selector_for_crew',  'uses' => 'CrewStatusController@redirectToStatusUpdate'));
        });

        Route::prefix('{crewId}/accounts')->group(function () {
            Route::get('/',     array('as' => 'users_for_crew',    'uses' => 'CrewAccountController@accounts'));
            Route::get('/new',  array('as' => 'new_user_for_crew', 'uses' => 'AccountController@new'));
        });

        Route::post('/crew/{crewId}/destroy', array('as' => 'destroy_crew', 'uses' => 'CrewController@destroy'));
    });


// ACCOUNTS
    Route::get('/account',					array('as' => 'users_index',	'uses' => 'AccountController@index'));
    Route::post('/account', 			    array('as' => 'register_user',	'uses' => 'RegisterController@postRegister'));
    Route::get('/account/{id}',			    array('as' => 'edit_user',		'uses' => 'AccountController@edit'));
    Route::post('/account/{id}',			array('as' => 'update_user',	'uses' => 'AccountController@update'));
    Route::post('/account/{id}/destroy',	array('as' => 'destroy_user',	'uses' => 'AccountController@destroy'));

});

 // These routes should be in the 'auth' group, but have been moved out for development
// INVENTORY
Route::get('/crew/{crewId}/inventory/{anything?}', 'PagesController@inventory');
