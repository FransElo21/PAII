<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Http\Request;
use App\Models\UndanganPengunjung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class pengunjungController extends Controller
{
    public function index_beranda()
    {
        $PengunjungID = Auth::id(); // Dapatkan ID pengguna yang sedang login
        $pengunjung = UndanganPengunjung::where('pengunjung_id', $PengunjungID)
                                ->orderBy('created_at', 'desc')
                                ->get();// Mengambil semua data UndanganPengunjung dengan pengurutan berdasarkan created_at
        $undanganMasuk = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Menunggu')->count();
        $undanganAkanDatang = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Diterima')->count();
        $undanganKadaluarsa = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Kadaluarsa')->count();
    
        $data = [
            'title' => 'Dashboard',
            'undangan_masuk' => $undanganMasuk,
            'undangan_akan_datang' => $undanganAkanDatang,
            'undangan_kadaluarsa' => $undanganKadaluarsa,
            'pengunjung' => $pengunjung
        ];
    
        return view('beranda', $data); // Mengirim data ke view
    }    

    public function edit()
    {
        $user = Auth::user();
        return view('edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validasi bahwa pengguna hanya dapat mengedit profil mereka sendiri
        if ($request->user()->id !== $user->id) {
            abort(403); // Unauthorized
        }
    
        // Perbarui profil pengguna
        $user = \App\Models\User::find($user->id); // Mengonversi menjadi instance model User yang sebenarnya
        $user->namaLengkap = $request->namaLengkap;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->status_pekerjaan = $request->status_pekerjaan;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;
    
        // Periksa dan simpan foto profil jika diunggah
        if ($request->hasFile('foto_profil')) {
            try {
                $image = $request->file('foto_profil');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('foto_profile_user_update'), $imageName);
                $user->foto_profil = 'foto_profile_user_update/' . $imageName;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal mengunggah foto profil.']);
            }
        }
    
        $user->save();
    
        // session()->flash('update_berhasil', true);
        // return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
        return Redirect::route('profile')->with('upsuccess', 'Profil berhasil diperbaharui');
    }
    
    public function index_pantau(){
        $host_id = Auth::id();

        $undangans = UndanganPengunjung::where('host_id', $host_id)->get();
        return view('pantau_kunjungan', compact('undangans'));
    }

    public function index_riwayat_pengunjung()
    {
        $pengunjung_id = Auth::id();
    
        $undangan = UndanganPengunjung::where('pengunjung_id', $pengunjung_id)
            ->whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])
            ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan updated_at secara descending
            ->get();
    
        return view('riwayat', compact('undangan'));
    }
    
    public function index_card_pengunjung(){
        $pengunjung_id = Auth::id();
    
        $menunggukonfirmasi = UndanganPengunjung::where('pengunjung_id', $pengunjung_id)->whereIn('status', ['Menunggu'])->get();
        $yangakandatang = UndanganPengunjung::where('pengunjung_id', $pengunjung_id)->whereIn('status', ['Diterima'])->get();
        $kadaluarsa = UndanganPengunjung::where('pengunjung_id', $pengunjung_id)->whereIn('status', ['Kadaluaras'])->get();
        return view('beranda', compact('menunggukonfirmasi','yangakandatang','kadaluarsa'));
    }

//     public function getUndanganByStatus($PengunjungID)
// {
//     // Mengambil data undangan berdasarkan status
//     $menunggukonfirmasi = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Menunggu')->get();
//     $yangakandatang = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Diterima')->get();
//     $kadaluarsa = UndanganPengunjung::where('pengunjung_id', $PengunjungID)->where('status', 'Kadaluarsa')->get();

//     // Mengembalikan data dalam satu array
//     return [
//         'menunggu_konfirmasi' => $menunggukonfirmasi,
//         'yang_akan_datang' => $yangakandatang,
//         'kadaluarsa' => $kadaluarsa,
//     ];
// }

    public function profile(){
        return view('profile');
    }

    
    
}
