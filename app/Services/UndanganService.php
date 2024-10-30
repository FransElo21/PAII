<?php

namespace App\Services;

use App\Models\UndanganPengunjung;
use Carbon\Carbon;

class UndanganService
{
    public static function updateExpiredStatus()
    {
        // Ambil data yang statusnya 'diterima' dan waktu_temu sudah lewat dari sekarang
        $expiredVisits = UndanganPengunjung::where('status', 'Menunggu')
            ->whereDate('waktu_temu', '<', Carbon::now())
            ->get();

        // Ubah status menjadi 'kadaluarsa'
        foreach ($expiredVisits as $visit) {
            $visit->status = 'Kadaluarsa';
            $visit->save();
        }
    }
}
