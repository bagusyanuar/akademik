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

});


