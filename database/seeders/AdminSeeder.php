<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Divisi;
use App\Models\entry_point;
use App\Models\lokasi;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat data admin
        Admin::create([
            'nama' => 'Admin_VMS',
            'username' => 'Adminvms',
            'password' => Hash::make('admin123'),
        ]);

         // Buat data admin
         entry_point::create([
            'nama' => 'Entry_point_VMS',
            'username' => 'Entrypointvms',
            'password' => Hash::make('entrypoint123'),
        ]);

        // Seed your data here
        $divisiList = [
            'Keasramaan',
            'Keuangan',
            'HRD',
            'Kemahasiswaan',
            // Tambahkan divisi lainnya sesuai kebutuhan
            'Marketing',
            'Teknologi Informasi',
            'Produksi',
            'Riset dan Pengembangan',
            'Pemasaran',
            'Operasional',
            'Manajemen Produk',
            'Hubungan Masyarakat',
            'Logistik',
            'Penjualan',
            'Akuntansi'
        ];

        foreach ($divisiList as $divisi) {
            Divisi::create([
                'nama_divisi' => $divisi,
            ]);
        }

    }
}
