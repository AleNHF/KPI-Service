<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\KPIController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/kpi/delivery-time-average', 'KPIController@supplierDeliveryTimeAverage');
    $router->get('/kpi/best-seller-products', 'KPIController@bestSellerProducts');
    $router->get('/kpi/income-year', 'KPIController@getIncomePerYear');
    $router->get('/kpi/last-sales', 'KPIController@getLastSales');
});

