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
//AuthController Route
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('updateAddress', 'AuthController@updateAddress')->middleware('auth:sanctum');
Route::get('user', 'AuthController@user')->middleware('auth:sanctum');
Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');

//BookingController Route
Route::post('createBooking', 'BookingController@createBooking')->middleware('auth:sanctum');
Route::post('scheduleBooking', 'BookingController@scheduleBooking')->middleware('auth:sanctum');
Route::get('fetchBookings', 'BookingController@fetchBookings')->middleware('auth:sanctum');

//ServiceController Route
Route::get('fetchServices', 'ServiceController@fetchServices')->middleware('auth:sanctum');
