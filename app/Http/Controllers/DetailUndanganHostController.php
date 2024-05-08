<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\undangan_host;
use Illuminate\Http\Request;

class DetailUndanganHostController extends Controller
{
    protected $table = 'detail_undangan_host';
    protected $guarded = [];

    public function undanganHost()
    {
        return $this->belongsTo(undangan_host::class);
    }

    public function pengunjung()
    {
        // Asumsikan pengunjung terdaftar atau tidak terdaftar dapat direferensikan menggunakan model pengunjung masing-masing
        return $this->belongsTo(Pengunjung::class);
    }

    public function store(Request $request)
    {
        // Validasi form untuk pengunjung terdaftar
        if ($request->has('pengunjung_terdaftar')) {
            $request->validate([
                'pengunjung_terdaftar' => 'required|exists:pengunjung_terdaftar,id'
                // Anda juga dapat menambahkan validasi lain sesuai kebutuhan
            ]);

            // Simpan data undangan untuk pengunjung terdaftar
            $undangan = new DetailUndanganHost();
            $undangan->undangan_id = $request->undangan_id;
            $undangan->pengunjung_id = $request->pengunjung_terdaftar;
            $undangan->is_terdaftar = true;
            $undangan->save();
        }

        // Jika pengunjung tidak terdaftar
        if ($request->has('nama_pengunjung_non_terdaftar')) {
            // Simpan data pengunjung tidak terdaftar
            $pengunjungNonTerdaftar = new PengunjungNonRegisterTerundang();
            $pengunjungNonTerdaftar->nama = $request->nama_pengunjung_non_terdaftar;
            // Simpan pengunjung tidak terdaftar
            $pengunjungNonTerdaftar->save();

            // Simpan data undangan untuk pengunjung tidak terdaftar
            $undangan = new DetailUndanganHost();
            $undangan->undangan_id = $request->undangan_id;
            $undangan->pengunjung_id = $pengunjungNonTerdaftar->id;
            $undangan->is_terdaftar = false;
            $undangan->save();
        }

        // Redirect atau berikan respons sesuai kebutuhan
    }
}
