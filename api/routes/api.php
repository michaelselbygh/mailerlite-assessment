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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/accounts/{id}', 'AccountsController@getAccount')->name('api.get.account');
Route::get('/accounts/{id}/transactions', 'TransactionsController@getAccountTransactions')->name('api.get.account.transactions');
Route::post('/accounts/{id}/transactions', 'TransactionsController@processTransaction')->name('api.process.transaction');
Route::get('/currencies', 'CurrenciesController@getCurrencies')->name('api.get.currencies');