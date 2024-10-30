<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UndanganPengunjung;
use App\Models\Lokasi;

class undangan extends Seeder
{
    /**
     * Menjalankan proses penanaman data.
     *
     * @return void
     */
    public function run()
    {
        // Dapatkan semua ID lokasi
        $lokasiIds = Lokasi::pluck('id');

        // Pastikan ada setidaknya 20 lokasi
        if ($lokasiIds->count() < 20) {
            // Masukkan lokasi tambahan jika diperlukan
            $jumlahLokasiTambahan = 20 - $lokasiIds->count();
            for ($i = 0; $i < $jumlahLokasiTambahan; $i++) {
                Lokasi::create([
                    // Buat lokasi tambahan jika diperlukan
                    'ruangan' => 'Ruangan Baru ' . ($i + 1),
                    'lantai' => 1 // Atur lantai default jika diperlukan
                ]);
            }
            // Perbarui daftar ID lokasi setelah penyisipan
            $lokasiIds = Lokasi::pluck('id');
        }

        // Masukkan data di sini
        for ($i = 0; $i < 20; $i++) {
            UndanganPengunjung::create([
                'subject' => 'Undangan ' . ($i + 1),
                'keterangan' => 'Keterangan Undangan ' . ($i + 1),
                'status' => 'Pending',
                'kunjungan_dari' => 'Sumber Kunjungan ' . ($i + 1),
                'waktu_temu' => now(),
                'waktu_kembali' => now()->addHours(2),
                'host_id' => 1, // Nilai host_id tetap
                'lokasi_id' => $lokasiIds->random(),
                'pengunjung_id' => 1, // Tetapkan ke pengunjung_id 1
                'type' => 'Type ' . ($i + 1),
                'keperluan' => 'pribadi', // Atur keperluan ke 'pribadi' atau 'pekerjaan'
                'check_in' => null, // Atur ke null awalnya
                'check_out' => null, // Atur ke null awalnya
            ]);
        }
    }
}
