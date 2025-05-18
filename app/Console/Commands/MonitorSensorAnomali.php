<?php

namespace App\Console\Commands;

use App\Helpers\FcmHelper;
use App\Models\DeviceToken;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MonitorSensorAnomali extends Command
{
    protected $signature = 'sensor:monitor-anomali';
    protected $description = 'Monitor data sensor dari Firebase dan kirim notifikasi jika ada anomali';

    public function handle()
    {
        $firebaseUrl = 'https://smartfeeding-7dca8-default-rtdb.asia-southeast1.firebasedatabase.app/MonitoringKolam/realtime.json';

        $this->info("Memulai pemantauan...");

        while (true) {
            try {
                $response = Http::get($firebaseUrl);
                if (!$response->successful()) {
                    $this->error("Gagal ambil data dari Firebase.");
                    sleep(5);
                    continue;
                }

                $data = $response->json();
                if (!$data) {
                    $this->warn("Data kosong.");
                    sleep(3);
                    continue;
                }

                // Ambil nilai sensor
                $suhu = $data['suhu'] ?? null;
                $ph = $data['ph'] ?? null;
                $kekeruhan = $data['kekeruhan'] ?? null;
                $sisaPakan = $data['sisa_pakan'] ?? null;

                $anomali = [];

                if ($suhu !== null && ($suhu < 20 || $suhu > 30)) {
                    $anomali[] = "Suhu air tidak normal: {$suhu}°C";
                }

                if ($ph !== null && ($ph < 6 || $ph > 9)) {
                    $anomali[] = "pH air tidak normal: {$ph}";
                }

                if ($kekeruhan === 'agak keruh' || $kekeruhan === 'sangat keruh') {
                    $anomali[] = "Kekeruhan air tidak normal: {$kekeruhan}";
                }

                if ($sisaPakan !== null && $sisaPakan < 30) {
                    $anomali[] = "Sisa pakan terlalu sedikit: {$sisaPakan}%";
                }

                if (count($anomali)) {
                    $message = implode("\n", $anomali);
                    $this->warn("🚨 Anomali terdeteksi!\n$message");

                    $tokens = DeviceToken::pluck('token');
                    foreach ($tokens as $token) {
                        FcmHelper::sendNotification($token, "🚨 Peringatan Kolam", $message);
                    }

                    // Hindari spam notifikasi, tunda sementara
                    sleep(30);
                } else {
                    $this->info("✔️ Sensor normal.");
                }

                sleep(5); // Cek ulang tiap 5 detik
            } catch (\Throwable $e) {
                $this->error("Terjadi error: " . $e->getMessage());
                sleep(5);
            }
        }
    }
}
