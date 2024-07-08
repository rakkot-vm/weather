<?php

use App\Http\Controllers\WeatherDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(WeatherDataController::class)
    ->prefix('weather')
    ->group(function () {
        Route::get('/by-day', 'getByDay');
    }
);
