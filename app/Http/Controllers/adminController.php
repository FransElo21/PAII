<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Host;
use App\Models\lokasi;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
    $hosts = Host::all();
    $title = "Halaman host";
    return view('admin.hostadmin', compact('hosts', 'title'));
    }

    
    public function store(Request $request)
    {
    // Validasi input
    $request->validate([
        'nama' => 'required',
        'username' => 'required|unique:host',
        'password' => 'required|confirmed',
        'jenis_kelamin' => 'required',
        'nomor_telepon' => 'required',
        'email' => 'required|email|unique:host',
        'alamat' => 'required',
        'divisi_id' => 'required|exists:divisi,id', // Ubah divisi menjadi divisi_id dan pastikan divisi tersebut ada dalam tabel divisi
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto profil (opsional)
    ]);

    // Simpan foto profil jika diunggah
    if ($request->hasFile('foto_profil')) {
        $foto_profil = $request->file('foto_profil');
        $nama_foto = time().'.'.$foto_profil->getClientOriginalExtension();
        $lokasi_simpan = '/foto_profile/';
        $foto_profil->move(public_path($lokasi_simpan), $nama_foto);
        $lokasi_simpan .= $nama_foto;
    } else {
        $lokasi_simpan = null; // Atur lokasi_simpan menjadi null jika tidak ada file yang diunggah
    }

    // Simpan data host baru
    Host::create([
        'nama' => $request->nama,
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'jenis_kelamin' => $request->jenis_kelamin,
        'nomor_telepon' => $request->nomor_telepon,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'divisi_id' => $request->divisi_id,
        'lokasi_id' => $request->lokasi_id,
        'foto_profil' => $lokasi_simpan, // Simpan lokasi file gambar profil ke dalam database
    ]);

    // Redirect ke halaman yang sesuai
    return redirect()->route('tampilkan_host')->with('success', 'Host berhasil ditambahkan.');
    }


    public function detail($id)
    {
    $host = Host::find($id);
    if (!$host) {
        abort(404); // Jika host tidak ditemukan, tampilkan halaman error 404
    }
    return view('admin.detailhost', compact('host'));
    }


    // public function update(Request $request, $id){
    // $host = Host::find($id);
    // $host->update($request->all());
    // return redirect()->route('hostadmin.show')->with('success', 'Data host berhasil diperbarui.');
    // }

    public function destroy(Host $host)
    {
        if ($host) {
            $host->delete();
            return redirect()->route('hostadmin.show')->with('success', 'Data host berhasil dihapus.');
        }
        return redirect()->route('hostadmin.show')->with('error', 'Data host tidak ditemukan.');
    }

    public function index_tambah_host()
    {
    $divisis = Divisi::all();
    $lokasis = lokasi::all();
    return view('admin.tambahhost', compact('divisis', 'lokasis'));
    }

    
    
}
