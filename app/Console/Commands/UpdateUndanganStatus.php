<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UndanganPengunjung;
use Carbon\Carbon;

class UpdateUndanganStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'undangan:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status undangan menjadi Kadaluarsa jika waktu_kembali telah terlewati';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ambil undangan yang statusnya belum dikonfirmasi atau diterima dan sudah melewati waktu_kembali
        $undangan = UndanganPengunjung::where('status', 'Menunggu')
            ->where('waktu_kembali', '<', Carbon::now())
            ->update(['status' => 'Kadaluarsa']);

        $this->info('Status undangan yang kadaluarsa telah diperbarui.');

        return 0;
    }
}
