<?php

// use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;

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

$api->get('/crew/{crewId}/inventory', 'ItemsController@indexForCrew');
$api->get('/crew/{crewId}/inventory/categories', 'ItemsController@categoriesForCrew');
$api->post('/crew/{crewId}/items', 'ItemsController@create');
$api->patch('/item/{itemId}', 'ItemsController@update');
$api->post('/item/{itemId}/increment', 'ItemsController@incrementItemQuantity');
$api->post('/item/{itemId}/decrement', 'ItemsController@decrementItemQuantity');
