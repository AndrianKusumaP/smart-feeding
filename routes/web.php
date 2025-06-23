<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\JadwalPakanController;
use App\Http\Controllers\JarakLontaranController;
use App\Http\Controllers\PakanManualController;

Route::middleware('auth')->group(function () {
  Route::get('/', [MonitoringController::class, 'index'])->name('dashboard');
  Route::resource('jadwal-pakan', JadwalPakanController::class);
  Route::get('/history', [HistoryController::class, 'index']);
  Route::get('/pakan-manual', [PakanManualController::class, 'index'])->name('pakan-manual.index');
  Route::get('/pakan-manual/edit', [PakanManualController::class, 'edit'])->name('pakan-manual.edit');
  Route::post('/pakan-manual/update', [PakanManualController::class, 'update'])->name('pakan-manual.update');
  Route::get('/jarak-lontaran', [JarakLontaranController::class, 'index'])->name('jarak-lontaran.index');
  Route::get('/jarak-lontaran/edit', [JarakLontaranController::class, 'edit'])->name('jarak-lontaran.edit');
  Route::post('/jarak-lontaran/update', [JarakLontaranController::class, 'update'])->name('jarak-lontaran.update');
  Route::post('/simpan-device-token', [DeviceTokenController::class, 'store']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
