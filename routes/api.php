<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->any('/fixer/{fixer_url_path}', 'External\FixerController@proxy')->where('fixer_url_path', '.*'); // I created this route to test and play around with the Fixer API

    $api->group(['prefix' => 'currencies'], function ($api) {
        //currency conversions
        $api->post('/covertCurrency','CurrencyConversion\CurrencyConversionController@covertCurrency');

        //list all currencies in dropdowns
        $api->get('/getAllCurrencies', 'CurrencyConversion\CurrencyConversionController@getAllCurrencies');

        //list all history conversions you've made
        $api->get('/conversions', 'CurrencyConversion\CurrencyConversionController@getAllCurrencyConversions');
    });
});

