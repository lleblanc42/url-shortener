<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api')->group(function () {
    Route::get('/top', [ShortenController::class, 'top']);

    Route::post('/shorten', [ShortenController::class, 'shortenUrl']);
});

Route::get('{url}', [ShortenController::class, 'redirect']);

Route::get('/', function () {
    return view('welcome');
});
