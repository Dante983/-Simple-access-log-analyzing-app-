<?php

use App\Http\Controllers\AggregateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LogController::class, 'display']);

Route::post('/log', [LogController::class, 'store']);
//Route::view('log', 'log');

Route::get('/aggregate/ip', [AggregateController::class, 'getIp']);

Route::get('/aggregate/method', [AggregateController::class, 'getMethod']);

Route::get('/aggregate/url', [AggregateController::class, 'getUrl']);

Route::get('/log/{file}', [DownloadsController::class, 'download']);

Route::delete('/log/{file}', [DeleteController::class, 'delete']);
