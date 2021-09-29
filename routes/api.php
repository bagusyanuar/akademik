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

Route::group(['prefix' => 'kelas'], function (){
    Route::post('/store', [\App\Http\Controllers\Admin\KelasController::class, 'store']);
});

Route::group(['prefix' => 'periode'], function (){
    Route::post('/store', [\App\Http\Controllers\Admin\PeriodeController::class, 'store']);
});

Route::group(['prefix' => 'mapel'], function (){
    Route::post('/store', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'store']);
});

Route::group(['prefix' => 'jadwal'], function (){
    Route::post('/store', [\App\Http\Controllers\Admin\JadwalController::class, 'store']);
    Route::get('/list', [\App\Http\Controllers\Admin\JadwalController::class, 'getJadwal']);
});
