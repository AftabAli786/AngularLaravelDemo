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
Route::any('add', 'ProductController@add');
Route::any('update', 'ProductController@update');
Route::any('delete', 'ProductController@delete');
Route::any('show', 'ProductController@show');
//user
Route::any('register', 'UserController@register');
Route::any('login', 'UserController@login');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
