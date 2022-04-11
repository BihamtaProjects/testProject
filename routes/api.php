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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('page', 'App\Http\Controllers\Api\PagesController@specificPage');

Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
Route::post('login_with_mobile', 'App\Http\Controllers\Api\AuthController@login_with_mobile');
Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('organizerRegister', 'App\Http\Controllers\Api\AuthController@organizerRegister');
Route::post('login_with_otp', 'App\Http\Controllers\Api\AuthController@login_with_otp');
Route::post('send_sms_otp', 'App\Http\Controllers\Api\AuthController@send_sms_otp');
Route::post('validate_sms_otp', 'App\Http\Controllers\Api\AuthController@validate_sms_otp');
Route::post('update_profile', 'App\Http\Controllers\Api\AuthController@update_profile')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Get('allServices','App\Http\Controllers\Api\ServiceController@allServices');
Route::Post('allSubjects','App\Http\Controllers\Api\SubjectsController@allSubjects');
Route::Get('allOrganizers','App\Http\Controllers\Api\OrganizersController@allOrganizers');
Route::Get('allTypes','App\Http\Controllers\Api\TypesController@allTypes');
Route::Post('selectedCovents','App\Http\Controllers\Api\CoventsController@selectedCovents');
Route::Post('covent','App\Http\Controllers\Api\CoventsController@specificCovent');
Route::Post('search','App\Http\Controllers\Api\SearchController@search');
Route::Post('user/changePassword','App\Http\Controllers\Api\AuthController@changePassword');



Route::group(['prefix'=>'user','middleware' => 'auth:api'], function () {

    Route::auth();
    Route::Post('/add/favorite','App\Http\Controllers\Api\favoritesController@addFavorite');
    Route::Post('/remove/favorite','App\Http\Controllers\Api\favoritesController@removeFavorite');
    Route::Get('/favorites','App\Http\Controllers\Api\favoritesController@userFavorites');
    Route::Post('addToCart','App\Http\Controllers\Api\CartsController@addToCart');
    Route::Get('showCart','App\Http\Controllers\Api\CartsController@showCart');
    Route::Get('cartToInvoice','App\Http\Controllers\Api\CartsController@cartToInvoice');
    Route::Post('deleteCart','App\Http\Controllers\Api\CartsController@deleteCart');
    Route::Post('updateCart','App\Http\Controllers\Api\CartsController@updateCart');
    Route::Post('showInvoice','App\Http\Controllers\Api\CartsController@showInvoice');
    Route::Post('saveTransactions','App\Http\Controllers\Api\TransactionsController@saveTransactions');
});
