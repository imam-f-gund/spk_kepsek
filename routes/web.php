<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RangkingKabupatenController;
use App\Http\Controllers\RangkingKecamatanController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return to_route('dashboard');
    } else {
        return to_route('login');
    }
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('cek-login', [AuthController::class, 'cek_login'])->name('cek_login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::resource('kriteria', KriteriaController::class);
Route::resource('indikator', IndikatorController::class);
Route::resource('kecamatan', KecamatanController::class);
Route::resource('sekolah', SekolahController::class);
Route::resource('periode', PeriodeController::class);
Route::resource('kepsek', KepalaSekolahController::class);
Route::resource('penilaian', PenilaianController::class);
Route::get('sekolah-per-kecamatan/{id}', [PenilaianController::class, 'getKepsekByKecamatan']);

Route::get('cek-kriteria', [KriteriaController::class, 'cek_kriteria']);
Route::get('cek-penilaian', [PenilaianController::class, 'cek_penilaian']);

Route::group(['prefix' => 'rangking'], function () {
    Route::get('kecamatan', [RangkingKecamatanController::class, 'index']);
    Route::get('kabupaten', [RangkingKabupatenController::class, 'index']);
});

Route::group(['prefix' => 'laporan'], function () {
    Route::get('kecamatan', [LaporanController::class, 'kecamatan']);
    Route::get('kabupaten', [LaporanController::class, 'kabupaten']);
});

Route::group(['prefix' => 'download'], function () {
    Route::post('kecamatan', [LaporanController::class, 'laporan_kecamatan']);
    Route::post('kabupaten', [LaporanController::class, 'laporan_kabupaten']);
});

Route::get('hitung-kecamatan', [RangkingKecamatanController::class, 'index']);
Route::post('hitung-kecamatan', [RangkingKecamatanController::class, 'hitung']);

Route::get('hitung-kabupaten', [RangkingKabupatenController::class, 'index']);
Route::post('hitung-kabupaten', [RangkingKabupatenController::class, 'hitung']);

Route::get('normalisasi', [RangkingKecamatanController::class, 'normalisasi']);

Route::get('cek-perhitungan-kecamatan', [RangkingKecamatanController::class, 'cek']);
