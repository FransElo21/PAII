<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Divisi;
use App\Models\Host;
use App\Models\Lokasi;
use App\Models\undangan_host;
use App\Models\UndanganPengunjung;
use App\Models\UpModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    public function index()
    {
    $hosts = Host::all();
    $divisions = Divisi::all();
    $locations = Lokasi::all();
    $divisis = Divisi::all();
    $lokasis = lokasi::all();
    $title = "Halaman host";
    return view('admin.hostadmin', compact('hosts','divisis','lokasis','divisions','locations', 'title'));
    }
    
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required',
        'username' => 'required|unique:host',
        'password' => 'required|confirmed',
        'jenis_kelamin' => 'required',
        'nomor_telepon' => 'required|string|max:15',
        'email' => 'required|email|unique:host',
        'alamat' => 'required',
        'divisi_id' => 'required|exists:divisi,id',
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Simpan foto profil jika diunggah
    if ($request->hasFile('foto_profil')) {
        $foto_profil = $request->file('foto_profil');
        $nama_foto = time().'.'.$foto_profil->getClientOriginalExtension();
        $lokasi_simpan = '/foto_profile/';
        $foto_profil->move(public_path($lokasi_simpan), $nama_foto);
        $lokasi_simpan .= $nama_foto;
    } else {
        $lokasi_simpan = null;
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
        'foto_profil' => $lokasi_simpan,
    ]);

    // Redirect ke halaman yang sesuai
    session()->flash('success_tambahhost', true);
    return redirect()->route('tampilkan_host')->with('success_tambahhost', 'Host berhasil ditambahkan.');
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

            session()->flash('success_hapushost', true);
            return redirect()->route('hostadmin.show')->with('success_hapushost', 'Data host berhasil dihapus.');
        }
        return redirect()->route('hostadmin.show')->with('error', 'Data host tidak ditemukan.');
    }

    public function index_tambah_host()
    {
        $divisis = Divisi::all();
        $lokasis = lokasi::all();
        return view('admin.tambahhost', compact('divisis', 'lokasis'));
    }

    public function index_riwayat()
    {
        
        // Mendapatkan data undangan dengan status "ditolak", "kadaluarsa", dan "selesai"
        // $undangan = UndanganPengunjung::whereIn('status', ['Ditolak', 'Kadaluarsa']) ->orWhere(function ($query) {$query->where('status', 'Selesai')->where('waktu_kembali', '<', now());})->get();
        
        $undangan = UndanganPengunjung::whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])->get();
        // $umodel = UndanganPengunjung::all();
                        
        
        $title = "Riwayat";
        return view('admin.riwayat_admin', compact('undangan', 'title'));
    }    

    public function edit_host($id)
    {
        $host = Host::find($id);
        $divisions = Divisi::all();
        $locations = Lokasi::all();
        // Add any additional data needed for the edit form, e.g., divisions, locations, etc.
        return view('admin/edit_host', compact('host', 'divisions', 'locations'));
    }

    public function update_host(Request $request, $id)
{
    $host = Host::findOrFail($id); // Mengambil host berdasarkan $id

    // Validasi dan proses data dari request
    $request->validate([
        'nama' => 'required',
        'username' => 'required',
        'alamat' => 'required',
        'nomor_telepon' => 'required',
        'email' => 'required|email',
        'jenis_kelamin' => 'required',
        'divisi_id' => 'required', // Pastikan divisi_id diisi
        'lokasi_id' => 'required',
    ]);

    // Memasukkan data dari request ke dalam model
    $host->nama = $request->nama;
    $host->username = $request->username;
    $host->alamat = $request->alamat;
    $host->nomor_telepon = $request->nomor_telepon;
    $host->email = $request->email;
    $host->jenis_kelamin = $request->jenis_kelamin;
    $host->divisi_id = $request->divisi_id; // Memasukkan divisi_id dari request
    $host->lokasi_id = $request->lokasi_id;

    // Menyimpan perubahan ke dalam basis data
    $host->save();

    // Redirect atau response sesuai kebutuhan aplikasi Anda
    return redirect()->route('tampilkan_host')->with('success_updatehost', 'Data host berhasil diperbaharui');
}

    public function index_cetak(){

        return view('admin/cetak');
    }

    public function index_cetak2(){

        return view('admin/cetak2');
    }

        public function cetak1()
        {
            $title = "Daftar Informasi Tamu";

            // Ambil undangan pengunjung yang statusnya 'Diterima'
            $undanganPengunjungDiterima = UndanganPengunjung::where('status', 'Diterima')->get();

            // Ambil undangan host yang statusnya 'Diterima'
            $undanganHostDiterima = undangan_host::where('status', 'Diterima')->get();

            // Gabungkan kedua hasil tersebut
            $undanganDiterima = $undanganPengunjungDiterima->concat($undanganHostDiterima);

            // Panggil view untuk cetak dengan data yang sudah digabung
            return view('admin.cetak', compact('undanganDiterima', 'title'));
        }

    public function cetak2()
    {
        $title = "Daftar Riwayat Undangan";

        // Ambil undangan pengunjung yang memiliki status 'Ditolak', 'Kadaluarsa', atau 'Selesai'
        $undanganPengunjung = UndanganPengunjung::whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])->get();

        // Panggil view untuk cetak dengan data yang sudah diambil
        return view('admin.cetak2', compact('undanganPengunjung', 'title'));
    }

    public function index_informasitamu() {
        $undangan = UndanganPengunjung::where('status', 'diterima')->with('divisi')->get();
        $divisis = Divisi::all();
        return view('admin.informasi_tamu', compact('undangan', 'divisis'));
    }    

    public function index_profile_admin()
    {
        // Ambil admin yang sedang login
        $admin = Auth::guard('admin')->user();

        return view('admin.profile_admin', compact('admin'));
    }

    public function editPasswordForm()
    {
        return view('admin.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user(); // Mengambil admin yang sedang login

        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|different:current_password',
            'new_password_confirmation' => 'same:new_password',
        ]);

        // Periksa apakah password saat ini sesuai
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Hash password baru
        $admin->password = Hash::make($request->new_password);

        // Simpan perubahan
        $admin->save();

        // Simpan pesan sukses ke dalam session
        session()->flash('custom_success', 'Password Berhasil Diperbaharui.');
        return redirect()->route('profile_admin.show')->with('success', 'Password Berhasil Diperbaharui.');
    }

}
