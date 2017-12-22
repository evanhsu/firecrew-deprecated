<?php

// use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function (Router $api) {
	$api->group(['namespace' => '\\App\\Http\\Controllers'], function (Router $api) {
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| responds to requests for api v1.  All controller paths are relative to
| `app\Http\Controllers`.
|
| TODO: Add this back in:
|	$api->group(['middleware' => 'api.auth'], function (Router $api) {
*/

		// Items
		$api->get('/crews/{crewId}/items', 'ItemsController@indexForCrew');
		$api->get('/crews/{crewId}/items/categories', 'ItemsController@categoriesForCrew');
		$api->post('/crews/{crewId}/items', 'ItemsController@create');
		$api->get('/items/{itemId}', 'ItemsController@show');
		$api->patch('/items/{itemId}', 'ItemsController@update');
		$api->post('/items/{itemId}/increment', 'ItemsController@incrementItemQuantity');
		$api->post('/items/{itemId}/decrement', 'ItemsController@decrementItemQuantity');

		// People
		$api->get('/people', 'PeopleController@indexAll');
		$api->get('/crews/{crewId}/people/{year}', 'PeopleController@indexForCrew');


        // STATUS
        // A "Status" is an object that belongs to 'Helicopter' or 'Crew'.
        // A new Status is created when a "Status Update" form is submitted.
        // A Status cannot be deleted or edited, only superceded. This maintains a history log of statuses.
        // Route::get('/status/{id}',	array('as' => 'show_status', 		'uses' => 'StatusController@show' ));
//        $api->post('/status',       array('as' => 'create_status',      'uses' => 'StatusController@store' ));
        $api->get('/status/all', 'StatusController@currentForAllResources');
	});
});
