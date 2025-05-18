<?php

use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\JadwalPakanController;
use App\Http\Controllers\LoginController;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Helpers\FcmHelper;

Route::middleware('auth')->group(function () {
  Route::get('/', [MonitoringController::class, 'index'])->name('dashboard');
  Route::resource('jadwal-pakan', JadwalPakanController::class);
  Route::get('/history', [HistoryController::class, 'index']);
  Route::get('/berat-pakan-manual/edit', [JadwalPakanController::class, 'manualEdit'])->name('berat-pakan-manual.edit');
  Route::post('/berat-pakan-manual/update', [JadwalPakanController::class, 'manualUpdate'])->name('berat-pakan-manual.update');
  Route::get('/jarak-lontaran/edit', [JadwalPakanController::class, 'jarakLontaranEdit'])->name('jarak-lontaran.edit');
  Route::post('/jarak-lontaran/update', [JadwalPakanController::class, 'jarakLontaranUpdate'])->name('jarak-lontaran.update');


  Route::get('/test-kirim-notif', function () {
    $token = DeviceToken::first()?->token;

    if (!$token) {
      return 'Tidak ada token di database.';
    }

    $res = FcmHelper::sendNotification(
      $token,
      'Peringatan Suhu!',
      'Suhu air kolam terlalu panas!'
    );

    return $res;
  });


  Route::post('/simpan-device-token', [App\Http\Controllers\DeviceTokenController::class, 'store']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
