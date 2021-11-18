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
    Route::post('/kelas', [\App\Http\Controllers\Admin\GuruController::class, 'setKelas']);
    Route::post('/kelas/drop', [\App\Http\Controllers\Admin\GuruController::class, 'dropKelas']);
});

Route::group(['prefix' => 'orang-tua'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\OrangTuaController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\OrangTuaController::class, 'addPage']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\OrangTuaController::class, 'editPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\OrangTuaController::class, 'store']);
    Route::post('/patch', [\App\Http\Controllers\Admin\OrangTuaController::class, 'patch']);
    Route::post('/destroy/{id}', [\App\Http\Controllers\Admin\OrangTuaController::class, 'destroy']);
});

Route::group(['prefix' => 'siswa'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\SiswaController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\SiswaController::class, 'addPage']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\SiswaController::class, 'editPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\SiswaController::class, 'store']);
    Route::post('/patch', [\App\Http\Controllers\Admin\SiswaController::class, 'patch']);
    Route::post('/destroy/{id}', [\App\Http\Controllers\Admin\SiswaController::class, 'destroy']);
});

Route::group(['prefix' => 'periode'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\PeriodeController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\PeriodeController::class, 'addPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\PeriodeController::class, 'store']);
});

Route::group(['prefix' => 'kelas'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\KelasController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\KelasController::class, 'addPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\KelasController::class, 'store']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\KelasController::class, 'editPage']);
    Route::post('/patch', [\App\Http\Controllers\Admin\KelasController::class, 'patch']);
    Route::post('/destroy/{id}', [\App\Http\Controllers\Admin\KelasController::class, 'destroy']);
});

Route::group(['prefix' => 'mata-pelajaran'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'addPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'store']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'editPage']);
    Route::post('/patch', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'patch']);
    Route::post('/destroy/{id}', [\App\Http\Controllers\Admin\MataPelajaranController::class, 'destroy']);
});

Route::group(['prefix' => 'jadwal'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\JadwalController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\JadwalController::class, 'addPage']);
    Route::post('/store', [\App\Http\Controllers\Admin\JadwalController::class, 'store']);
    Route::get('/list', [\App\Http\Controllers\Admin\JadwalController::class, 'getJadwal']);
    Route::get('/listBy', [\App\Http\Controllers\Admin\JadwalController::class, 'getSubjectBy']);
    Route::post('/destroy', [\App\Http\Controllers\Admin\JadwalController::class, 'destroy']);
});

Route::group(['prefix' => 'pelajaran-kelas'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\PelajaranKelasController::class, 'index']);
    Route::get('/list', [\App\Http\Controllers\Admin\PelajaranKelasController::class, 'getList']);
    Route::post('/store', [\App\Http\Controllers\Admin\PelajaranKelasController::class, 'store']);
    Route::post('/destroy', [\App\Http\Controllers\Admin\PelajaranKelasController::class, 'destroy']);
});

Route::group(['prefix' => 'penilaian'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\PenilaianController::class, 'index']);
    Route::get('/check', [\App\Http\Controllers\Admin\PenilaianController::class, 'justCheck']);
    Route::get('/getNilai', [\App\Http\Controllers\Admin\PenilaianController::class, 'getNilai']);
    Route::post('/saveNilai', [\App\Http\Controllers\Admin\PenilaianController::class, 'saveNilai']);
});

Route::group(['prefix' => 'absen'], function (){
    Route::get('/', [\App\Http\Controllers\Admin\AbsensiController::class, 'index']);
    Route::get('/list', [\App\Http\Controllers\Admin\AbsensiController::class, 'getList']);
//    Route::get('/check', [\App\Http\Controllers\Admin\PenilaianController::class, 'justCheck']);
//    Route::get('/getNilai', [\App\Http\Controllers\Admin\PenilaianController::class, 'getNilai']);
//    Route::post('/saveNilai', [\App\Http\Controllers\Admin\PenilaianController::class, 'saveNilai']);
});


