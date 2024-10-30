<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Host;
use App\Models\logs_undangan_pengunjung;
use App\Models\lokasi;
use App\Models\Pengunjung;
use App\Models\PengunjungUndangan;
use App\Models\UndanganPengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UndanganPengunjungController extends Controller
{
    public function index_janji_temu()
    {
        $hosts = Host::all();
        $pengunjungs = Pengunjung::all();
        return view('janji_temu', compact('hosts', 'pengunjungs'));
    }

    public function index_undangan()
    {
        $hosts = Host::all();
        $pengunjungs = Pengunjung::all();
        return view('buat_undangan', compact('hosts', 'pengunjungs'));
    }

    public function create()
    {
        return view('undangan.create');
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'subject' => 'required|string|max:255',
        'keterangan' => 'required|string|max:255',
        'kunjungan_dari' => 'required|string|max:255',
        'waktu_temu' => 'required|date',
        'waktu_kembali' => 'nullable|date',
        'host_id' => 'required|exists:host,id',
        'keperluan' => 'required|string|in:Pribadi,Pekerjaan',
        'num_visitors' => 'nullable|integer|min:0', // Tidak lagi required
    ]);

    // Validasi pengunjung tambahan jika ada
    if ($request->num_visitors > 0) {
        $request->validate([
            'visitors' => 'required|array',
            'visitors.*.name' => 'required|string|max:255',
            'visitors.*.email' => 'required|email|max:255',
            'visitors.*.phone' => 'required|string|max:15',
            'visitors.*.nik' => 'required|string|max:20', // Validasi untuk NIK
        ]);
    }

    // Ambil lokasi_id dari tabel hosts berdasarkan host_id
    $host = Host::find($request->host_id);
    if (!$host || !$host->lokasi_id) {
        return redirect()->back()->withErrors(['host_id' => 'Host tidak memiliki lokasi yang terkait.']);
    }

    // Tetapkan nilai pengunjung_id ke dalam array $request dan tambahkan status serta lokasi_id
    $request->merge(['pengunjung_id' => Auth::id(), 'status' => 'Menunggu', 'lokasi_id' => $host->lokasi_id]);

    // Buat undangan
    $undangan = UndanganPengunjung::create($request->only([
        'subject', 'keterangan', 'status', 'kunjungan_dari', 'waktu_temu',
        'waktu_kembali', 'host_id', 'pengunjung_id', 'lokasi_id', 'keperluan'
    ]));

    // Tambahkan pengunjung tambahan jika ada
    if ($request->num_visitors > 0) {
        foreach ($request->visitors as $visitor) {
            GroupMember::create([
                'undangan_id' => $undangan->id,
                'name' => $visitor['name'],
                'email' => $visitor['email'],
                'phone' => $visitor['phone'],
                'nik' => $visitor['nik'], // Simpan juga NIK
            ]);
        }
    }

    // Simpan log undangan pengunjung
    logs_undangan_pengunjung::create([
        'undangan_id' => $undangan->id,
        'pengunjung_id' => Auth::id(),
        'check_in' => null,
        'check_out' => null,
    ]);

    // Redirect dengan pesan sukses
    session()->flash('buat_undangan_berhasil', true);
    return redirect()->route('undangan.show')->with('buat_undangan_berhasil', 'Undangan berhasil dibuat.');
}

    public function detail_undangan($id)
    {
        $undangan_pengunjung = UndanganPengunjung::findOrFail($id);
        return view('detail_undangan', compact('undangan_pengunjung'));
    }

    public function checkAndUpdateStatus()
    {
        $now = Carbon::now('Asia/Jakarta');

        // Update status undangan yang sudah kadaluarsa
        UndanganPengunjung::where('status', 'Menunggu')
            ->where('waktu_kembali', '<', $now)
            ->update(['status' => 'Kadaluarsa']);

        $undangan_masuk = UndanganPengunjung::where('status', 'Menunggu')->count();
        $undangan_akan_datang = UndanganPengunjung::where('status', 'Diterima')->count();
        $undangan_kadaluarsa = UndanganPengunjung::where('status', 'Kadaluarsa')->count();

        return response()->json([
            'undangan_masuk' => $undangan_masuk,
            'undangan_akan_datang' => $undangan_akan_datang,
            'undangan_kadaluarsa' => $undangan_kadaluarsa
        ]);
    }

public function filterRiwayat(Request $request)
    {
        $tanggalFilter = $request->input('tanggalFilter');

        // Query untuk mengambil data dari database berdasarkan tanggal
        $riwayats = UndanganPengunjung::where('waktu_temu', $tanggalFilter)->get();

        return response()->json($riwayats);
    }

    public function updateUndanganStatus(Request $request)
    {
        try {
            // Ambil semua undangan yang statusnya diterima
            $undangans = UndanganPengunjung::where('status', 'Diterima')->get();

            foreach ($undangans as $undangan) {
                // Cek apakah undangan ini memiliki log dengan check_out yang sudah terisi
                $log = logs_undangan_pengunjung::where('undangan_id', $undangan->id)
                    ->whereNotNull('check_out')
                    ->first();

                if ($log) {
                    // Update status undangan menjadi 'Selesai'
                    $undangan->status = 'Selesai';
                    $undangan->save();
                }
            }

            return response()->json(['message' => 'Status undangan berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

}