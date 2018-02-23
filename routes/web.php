<?php
use Illuminate\Support\Facades\Route;

Route::get('/', array('as' => 'sales', 'uses' => 'PagesController@sales'));
Route::get('/summary', array('as' => 'summary', 'uses' => 'Status\SummaryController@index'));
Route::get('/map', array('as' => 'map', 'uses' => 'MapController@getMap'));
Route::get('/home', 'HomeController@index');
Route::get('/privacy', 'PagesController@privacy');

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
    Route::get('/aircraft', array('as' => 'aircraft_index', 'uses' => 'AircraftController@index'));
    Route::get('/aircraft/{tailnumber}/status', array('as' => 'current_status_for_aircraft', 'uses' => 'AircraftController@showCurrentStatus'));
    Route::get('/aircraft/{tailnumber}/update', array('as' => 'new_status_for_aircraft', 'uses' => 'AircraftController@newStatus'));
    Route::post('/aircraft/{tailnumber}/release', array('as' => 'release_aircraft', 'uses' => 'AircraftController@releaseFromCrew'));


// CREWS
    Route::prefix('crew')->group(function () {

        Route::namespace('Crew')->group(function () {
            Route::get('/',                 array('as' => 'crews_index', 'uses' => 'CrewController@index'));
            Route::post('/',                array('as' => 'store_crew', 'uses' => 'CrewController@store'));
            Route::get('/new',              array('as' => 'new_crew', 'uses' => 'CrewController@create'));
            Route::post('/destroy',         array('as' => 'destroy_crew', 'uses' => 'CrewController@destroy'));

            Route::prefix('{crewId}')->group(function () {
                Route::get('/',             array('as' => 'crew', 'uses' => 'CrewController@show'));
                Route::post('/',            array('as' => 'update_crew', 'uses' => 'CrewController@update')); // TODO: Update method to PATCH
                Route::get('/identity',     array('as' => 'edit_crew', 'uses' => 'CrewController@edit'));
                Route::get('/accounts',     array('as' => 'users_for_crew', 'uses' => 'CrewAccountController@index'));
            });
        });

        Route::namespace('Status')->group(function () {
            Route::prefix('{crewId}')->group(function () {

                Route::prefix('status')->group(function () {
                    Route::get('/router',           array('as' => 'status_form_selector_for_crew', 'uses' => 'CrewStatusController@redirectToStatusUpdate'));
                    Route::get('/{tailnumber?}',    array('as' => 'new_status_for_crew', 'uses' => 'CrewStatusController@newStatus'));
                    Route::post('/',                array('as' => 'store_status_for_crew', 'uses' => 'CrewStatusController@store'));
                });

                Route::prefix('resource')->group(function () {
                    Route::post('/{identifier}/status', array('as' => 'store_status_for_crew_resource', 'uses' => 'ResourceStatusController@store'));
                });
            });
        });
    });


// STATUS

// ACCOUNTS
    Route::get('/account', array('as' => 'users_index', 'uses' => 'AccountController@index'));
    Route::post('/account', array('as' => 'register_user', 'uses' => 'Auth\RegisterController@postRegister'));
    Route::get('/account/{id}', array('as' => 'edit_user', 'uses' => 'AccountController@edit'));
    Route::post('/account/{id}', array('as' => 'update_user', 'uses' => 'AccountController@update'));
    Route::post('/account/{id}/destroy', array('as' => 'destroy_user', 'uses' => 'AccountController@destroy'));

    Route::get('crew/{crewId}/accounts/new', array('as' => 'new_user_for_crew', 'uses' => 'AccountController@getRegister'));
    Route::post('crew/{crewId}/accounts', array('as' => 'create_user_for_crew', 'uses' => 'AccountController@postRegisterUserForCrew'));

});

// These routes should be in the 'auth' group, but have been moved out for development
// INVENTORY
Route::get('/crew/{crewId}/inventory/{anything?}', 'PagesController@inventory');

/*
 * TODO: refactor crew status:
 * Visiting the /crew/1/status/3 route will display the "Status Update" page.
 * Status data for the crew and all its resources will be loaded, and the active
 * tab will be set to the resource with id=3
 *
 * Visiting /crew/1/status will display the status update page for the Crew itself (first tab) (a CrewStatus)
 */