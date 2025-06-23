<?php

namespace App\Console\Commands;

use App\Helpers\FcmHelper;
use App\Models\DeviceToken;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CekESP32Offline extends Command
{
    protected $signature = 'esp32:cek-offline';
    protected $description = 'Cek apakah ESP32 sedang offline dan kirim notifikasi';

    public function handle()
    {
        $firebaseUrl = 'https://smartfeeding-7dca8-default-rtdb.asia-southeast1.firebasedatabase.app/MonitoringKolam/realtime.json';
    
        try {
            $response = Http::get($firebaseUrl);
    
            if (!$response->successful()) {
                $this->error('Gagal ambil data dari Firebase');
                return;
            }
    
            $data = $response->json() ?? [];
            $waktuStr = $data['waktu_terakhir'] ?? null;
    
            if (!$waktuStr) {
                $this->kirimNotifikasiOffline("📴 Alat sedang Offline");
                return;
            }
    
            // Parse waktu terakhir dengan format ISO dan offset
            try {
                $waktuTerakhir = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:sO', $waktuStr);
            } catch (\Exception $e) {
                $this->error("❌ Format waktu tidak valid: {$waktuStr}");
                return;
            }
    
            $now = now();
            $selisihDetik = $waktuTerakhir->diffInSeconds($now); // Positif
    
            $this->info("⏰ Waktu sekarang (Laravel): {$now->toIso8601String()}");
            $this->info("⏱️ waktu_terakhir (Firebase): {$waktuTerakhir->toIso8601String()}");
            $this->info("🕒 Selisih detik: {$selisihDetik}");
    
            if ($selisihDetik > 60) {
                $this->kirimNotifikasiOffline("📴 Alat sedang offline");
            } else {
                $this->info('✔️  ESP32 online');
            }
    
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
    
    protected function kirimNotifikasiOffline($pesan)
    {
        if (Cache::get('esp32_offline_sent')) {
            $this->warn('📴 Notifikasi offline sudah dikirim sebelumnya, tidak dikirim ulang.');
            return;
        }

        $this->warn($pesan);

        $tokens = DeviceToken::pluck('token');
        foreach ($tokens as $token) {
            FcmHelper::sendNotification($token, '🚨 Peringatan Koneksi', $pesan);
        }

        Cache::put('esp32_offline_sent', true, now()->addMinutes(10));
    }
}
