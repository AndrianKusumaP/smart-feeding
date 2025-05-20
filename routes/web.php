<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\JadwalPakanController;

Route::middleware('auth')->group(function () {
  Route::get('/', [MonitoringController::class, 'index'])->name('dashboard');
  Route::resource('jadwal-pakan', JadwalPakanController::class);
  Route::get('/history', [HistoryController::class, 'index']);
  Route::get('/berat-pakan-manual/edit', [JadwalPakanController::class, 'manualEdit'])->name('berat-pakan-manual.edit');
  Route::post('/berat-pakan-manual/update', [JadwalPakanController::class, 'manualUpdate'])->name('berat-pakan-manual.update');
  Route::get('/jarak-lontaran/edit', [JadwalPakanController::class, 'jarakLontaranEdit'])->name('jarak-lontaran.edit');
  Route::post('/jarak-lontaran/update', [JadwalPakanController::class, 'jarakLontaranUpdate'])->name('jarak-lontaran.update');
  Route::post('/simpan-device-token', [DeviceTokenController::class, 'store']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
