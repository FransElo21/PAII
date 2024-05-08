<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\PengunjungUndangan;
use App\Models\UndanganPengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UndanganPengunjungController extends Controller
{
    public function index_janji_temu(){
        $hosts = Host::all();
        return view('janji_temu', compact('hosts'));
    }

    // public function store(Request $request)
    // {
    //     // Validasi data
    //     $validatedData = $request->validate([
    //         'subject' => 'required',
    //         'host_id' => 'required|exists:host,id',
    //         'waktu_temu' => 'required|date',
    //         'waktu_kembali' => 'required|date|after:waktu_temu',
    //         'keterangan' => 'required',
    //     ]);

    //     // Mendapatkan ID pengunjung yang sedang membuat undangan
    //     $pengunjung_id = Auth::id();

    //     // Menambahkan pengunjung_id ke dalam validatedData
    //     $validatedData['pengunjung_id'] = $pengunjung_id;

    //     // Simpan data janji temu
    //     UndanganPengunjung::create($validatedData);

    //     // Redirect dengan pesan sukses
    //     return redirect('janji_temu')->with('success', 'Janji Temu berhasil ditambahkan.');
    // }

    // public function store(Request $request)
    // {
    //     // Simpan data undangan
    //     $undangan = new Undangan;
    //     $undangan->subject = $request->subject;
    //     // tambahkan atribut lainnya
    //     $undangan->save();

    //     // Simpan data pengunjung
    //     $pengunjung = new Pengunjung;
    //     $pengunjung->namaLengkap = $request->namaLengkap;
    //     // tambahkan atribut lainnya
    //     $pengunjung->save();

    //     // Attach pengunjung ke undangan
    //     $undangan->pengunjung()->attach($pengunjung->id);

    //     return redirect()->route('undangan.index')->with('success', 'Undangan berhasil dibuat');
    // }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'subject' => 'required|string',
            'keterangan' => 'required|string',
            'waktu_temu' => 'required|date',
            'waktu_kembali' => 'required|date',
            'host_id' => 'required|exists:host,id',
            'pengunjung_id' => 'required|exists:pengunjung,id',
        ]);

        // Simpan data undangan_pengunjung
        $undangan = new UndanganPengunjung();
        $undangan->subject = $request->subject;
        $undangan->keterangan = $request->keterangan;
        $undangan->waktu_temu = $request->waktu_temu;
        $undangan->waktu_kembali = $request->waktu_kembali;
        $undangan->host_id = $request->host_id;
        $undangan->pengunjung_id = $request->pengunjung_id;
        $undangan->save();

        // Jika jenis undangan adalah berkelompok, simpan data pengunjung tambahan
        if ($request->invitationType === 'group' && $request->has('additionalGuests')) {
            foreach ($request->additionalGuests as $guestName) {
                // Buat pengunjung baru
                $pengunjung = new PengunjungUndangan();
                $pengunjung->pengunjung_id = $undangan->pengunjung_id;
                // Disesuaikan sesuai kebutuhan Anda
                // Misalnya, jika hanya menyimpan nama pengunjung, gunakan kolom 'nama'
                $pengunjung->nama = $guestName;
                $pengunjung->save();
            }
        }

        // Redirect atau response sesuai kebutuhan Anda
        return redirect()->route('nama_route')->with('success', 'Undangan berhasil dibuat!');
    }

    public function index_beranda(){
        $undangans = UndanganPengunjung::all();
        $data = [
            "title" => "Dashboard"
        ];
        return view('beranda', compact('undangans'))->with($data);
    }   

    public function detail_undangan($id)
    {
        // $undangan = Undangan::findOrFail($id);
        $undangan_pengunjung = UndanganPengunjung::findOrFail($id);
        return view('detail_undangan', compact('undangan_pengunjung'));
    }
}
