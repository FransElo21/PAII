<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;

class RegisterController extends Controller
{
    public function showFormRegister()
    {
        return view('registrasi');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'namaLengkap' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:pengunjung',
    //         'password' => 'required|string|min:6|confirmed',
    //         'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //         'nomor_telepon' => 'required|string|max:15',
    //         'email' => 'required|string|email|max:255|unique:pengunjung',
    //         'alamat' => 'required|string|max:255',
    //     ]);

    //     $data = $request->all();
    //     $data['password'] = bcrypt($request->password);

    //     Pengunjung::create($data);

    //     return redirect()->route('login.showLoginForm')->with('success', 'Registrasi berhasil!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengunjung',
            'password' => 'required|string|min:6|confirmed',
            'status_pekerjaan' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pengunjung',
            'alamat' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto profil (opsional)
        ]);

        $lokasi_simpan = null; // Inisialisasi lokasi penyimpanan

        // Simpan foto profil jika diunggah
        if ($request->hasFile('foto_profil')) {
            $foto_profil = $request->file('foto_profil');
            $nama_foto = time().'.'.$foto_profil->getClientOriginalExtension();
            $lokasi_simpan = '/foto_profile_user/'; // Lokasi penyimpanan
            $foto_profil->move(public_path($lokasi_simpan), $nama_foto);
            $lokasi_simpan .= $nama_foto;
        }
        
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['foto_profil'] = $lokasi_simpan; // Menambahkan lokasi foto profil ke dalam data
        
        Pengunjung::create($data);
        
        // Menambahkan session registrasi_berhasil
        session()->flash('registrasi_berhasil', true);
        
        return redirect()->route('login.showLoginForm');
    }

    public function coba(){
        return view('coba');
    }

    public function app(){
        return view('layouts/app');
    }
}
