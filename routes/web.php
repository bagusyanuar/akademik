<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::match(['POST', 'GET'], '/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('main.index');
});

Route::group(['prefix' => 'admin'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'addPage']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'editPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\AdminController::class, 'store']);
    Route::post('/patch', [\App\Http\Controllers\Admin\AdminController::class, 'patch']);

});

Route::group(['prefix' => 'guru'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\GuruController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\GuruController::class, 'addPage']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\GuruController::class, 'editPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\GuruController::class, 'store']);
    Route::post('/patch', [\App\Http\Controllers\Admin\GuruController::class, 'patch']);
    Route::post('/destroy/{id}', [\App\Http\Controllers\Admin\GuruController::class, 'destroy']);
});


