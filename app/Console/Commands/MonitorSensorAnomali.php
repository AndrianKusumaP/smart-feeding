<?php

namespace App\Console\Commands;

use App\Helpers\FcmHelper;
use App\Models\DeviceToken;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonitorSensorAnomali extends Command
{
    protected $signature = 'sensor:monitor-anomali';
    protected $description = 'Monitor data sensor dari Firebase dan kirim notifikasi jika ada anomali';

    public function handle()
    {
        $firebaseUrl = 'https://smartfeeding-7dca8-default-rtdb.asia-southeast1.firebasedatabase.app/MonitoringKolam/realtime.json';

        try {
            $response = Http::get($firebaseUrl);

            if (!$response->successful()) {
                $this->error('Gagal ambil data Firebase');
                return;
            }

            $data = $response->json() ?? [];
            $anomali = [];

            $suhu       = $data['suhu']        ?? null;
            $ph         = $data['ph']          ?? null;
            $kekeruhan  = $data['kekeruhan']   ?? null;
            $sisaPakan  = $data['pakan']       ?? null;

            if ($suhu !== null) {
                if ($suhu < 20) {
                    $anomali[] = "🌡️ Suhu air terlalu dingin: {$suhu}°C";
                } elseif ($suhu > 30) {
                    $anomali[] = "🌡️ Suhu air terlalu panas: {$suhu}°C";
                }
            }

            if ($ph !== null) {
                if ($ph < 6) {
                    $anomali[] = "🧪 pH air terlalu asam: {$ph}";
                } elseif ($ph > 9) {
                    $anomali[] = "🧪 pH air terlalu basa: {$ph}";
                }
            }

            if ($kekeruhan !== null) {
                $keruh = strtolower(trim($kekeruhan));
                if (in_array($keruh, ['agak keruh', 'sangat keruh'])) {
                    $anomali[] = "🌫️ Kekeruhan air tidak normal: {$kekeruhan}";
                }
            }

            if ($sisaPakan !== null && $sisaPakan < 30) {
                $anomali[] = "🐟 Sisa pakan terlalu sedikit: {$sisaPakan}%";
            }

            if (count($anomali) > 0) {
                $pesan = implode("\n", $anomali);
                $this->warn("🚨 Anomali:\n" . $pesan);

                $tokens = DeviceToken::pluck('token');

                foreach ($tokens as $token) {
                    FcmHelper::sendNotification($token, '🚨 Peringatan Kolam', $pesan);
                }
            } else {
                $this->info('✔️  Semua sensor normal');
            }

        } catch (\Throwable $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
