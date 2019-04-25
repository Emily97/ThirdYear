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

Route::get('/books', 'BookController@apiIndex');
Route::get('/books/{id}', 'BookController@apiShow');
Route::post('/books', 'BookController@apiStore');
Route::put('/books/{id}', 'BookController@apiUpdate');
Route::delete('/books/{id}', 'BookController@apiDelete');
