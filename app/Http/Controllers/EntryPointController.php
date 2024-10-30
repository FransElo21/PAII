<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use DateTimeZone;
use App\Models\Pengunjung;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UndanganPengunjung;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\logs_undangan_pengunjung;
use App\Models\pengunjung_undangan_host;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EntryPointController extends Controller
{
    // public function index_entrypoint()
    // {
    //     $title = "Beranda";
    //     return view('entry_point.berandaentrypoint', compact('title'));
    // }

    public function index_entrypoint(){
        // Mendapatkan tanggal hari ini dalam zona waktu 'Asia/Jakarta'
        $today = Carbon::now('Asia/Jakarta')->toDateString();
    
        // Mendapatkan semua kunjungan yang dijadwalkan hari ini
        $datasemua_kunjungan = UndanganPengunjung::whereDate('waktu_temu', $today)->get();
        $yang_akan_datang = UndanganPengunjung::whereDate('waktu_temu', $today)->where('status', 'Diterima')->get();
        $kadaluarsa = UndanganPengunjung::whereDate('waktu_temu', $today)->where('status', 'Kadaluarsa')->get();
    
        // Menghitung jumlah semua kunjungan hari ini
        $semua_kunjungan = $datasemua_kunjungan->count();
    
        // Mendapatkan pengunjung terbaru
        $recentUsers = Pengunjung::orderBy('last_login', 'desc')->take(5)->get();
        
        // Menghitung kunjungan yang diterima hari ini
        $kunjungan_hari_ini = UndanganPengunjung::where('status', 'Diterima')
            ->whereDate('waktu_temu', $today)
            ->count();
    
        // Menghitung jumlah kunjungan dengan check_in dan check_out yang berisi
        $logs_kunjungan_check_in_out = logs_undangan_pengunjung::whereHas('undangan_pengunjung', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today)
                  ->whereNotNull('check_in')
                  ->whereNotNull('check_out');
        })->count();
    
        // Menghitung jumlah anggota grup yang diundang dengan check_in dan check_out yang berisi
        $groupMember_kunjungan_check_in_out = GroupMember::whereHas('undangan', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today)
                  ->whereNotNull('check_in')
                  ->whereNotNull('check_out');
        })->count();
    
        // Menghitung jumlah host pengunjung yang diundang dengan check_in dan check_out yang berisi
        $hostKunjungan_check_in_out = pengunjung_undangan_host::whereHas('undanganHost', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today)
                  ->whereNotNull('check_in')
                  ->whereNotNull('check_out');
        })->count();
    
        // Menggabungkan jumlah dari semua data
        $total_kunjungan_check_in_out = $logs_kunjungan_check_in_out + $groupMember_kunjungan_check_in_out + $hostKunjungan_check_in_out;
    
        // Menghitung jumlah kunjungan kadaluarsa hari ini
        $kunjungan_kadaluarsa = UndanganPengunjung::where('status', 'Kadaluarsa')
            ->whereDate('waktu_temu', $today)
            ->count();
    
        // Menyiapkan data untuk pengunjung yang mendaftar
        $registers = logs_undangan_pengunjung::whereHas('undangan_pengunjung', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today);
        })->get()->map(function($register) {
            return [
                'id' => $register->id,
                'name' => $register->pengunjung->namaLengkap,
                'check_in' => $register->check_in,
                'check_out' => $register->check_out,
                'waktu_temu' => $register->undangan_pengunjung->waktu_temu,
                'waktu_kembali' => $register->undangan_pengunjung->waktu_kembali,
                'subject' => $register->undangan_pengunjung->subject,
                'status' => $register->undangan_pengunjung->status,
                'Host' => $register->undangan_pengunjung->host->nama
            ];
        })->filter(function($register) {
            return $register['check_in'] || $register['check_out'];
        });
        
        // Menyiapkan data untuk anggota grup yang diundang
        $nonRegisters = GroupMember::whereHas('undangan', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today);
        })->get()->map(function($nonRegister) {
            return [
                'id' => $nonRegister->id,
                'name' => $nonRegister->name,
                'check_in' => $nonRegister->check_in,
                'check_out' => $nonRegister->check_out,
                'waktu_temu' => $nonRegister->undangan->waktu_temu,
                'waktu_kembali' => $nonRegister->undangan->waktu_kembali,
                'subject' => $nonRegister->undangan->subject,
                'status' => $nonRegister->undangan->status,
                'Host' => $nonRegister->undangan->host->nama
            ];
        })->filter(function($nonRegister) {
            return $nonRegister['check_in'] || $nonRegister['check_out'];
        });
        
        // Menyiapkan data untuk host pengunjung yang diundang
        $hostRegisters = pengunjung_undangan_host::whereHas('undanganHost', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today);
        })->get()->map(function($hostRegister) {
            return [
                'id' => $hostRegister->id,
                'name' => $hostRegister->nama,
                'check_in' => $hostRegister->check_in, // Perbaiki jika perlu
                'check_out' => $hostRegister->check_out, // Perbaiki jika perlu
                'waktu_temu' => $hostRegister->undanganHost->waktu_temu,
                'waktu_kembali' => $hostRegister->undanganHost->waktu_kembali,
                'subject' => $hostRegister->undanganHost->subject,
                'status' => $hostRegister->undanganHost->status,
                'Host' => $hostRegister->undanganHost->host->nama
            ];
        })->filter(function($hostRegister) {
            return $hostRegister['check_in'] || $hostRegister['check_out'];
        });
    
        // Menggabungkan semua data menjadi satu
        $combinedData = $registers->merge($nonRegisters)->merge($hostRegisters);
    
        // Menghitung jumlah anggota grup yang tercatat dengan check_in atau check_out
        $nonRegistersCount = GroupMember::whereHas('undangan', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today);
        })->where(function($query) {
            $query->whereNotNull('check_in')
                ->orWhereNotNull('check_out');
        })->count();
    
        // Menghitung jumlah host pengunjung yang tercatat dengan check_in atau check_out
        $hostRegistersCount = pengunjung_undangan_host::whereHas('undanganHost', function ($query) use ($today) {
            $query->whereDate('waktu_kembali', $today);
        })->where(function($query) {
            $query->whereNotNull('check_in')
                ->orWhereNotNull('check_out');
        })->count();
    
        // Menggabungkan jumlah dari semua data
        $totalCount = $nonRegistersCount + $hostRegistersCount;
    
        // Mengembalikan view dengan data yang sudah dipersiapkan
        return view('entry_point.berandaentrypoint', compact(
            'semua_kunjungan',
            'totalCount',
            'kunjungan_hari_ini',
            'kunjungan_kadaluarsa',
            'recentUsers',
            'total_kunjungan_check_in_out',
            'datasemua_kunjungan',
            'combinedData',
            'yang_akan_datang',
            'kadaluarsa'
        ));
    }
    
    
    
    public function scanQrCode(Request $request)
{
    try {
        // Mendapatkan data QR code yang dipindai dari permintaan (request)
        $qrCodeData = json_decode($request->input('qr_code'), true);

        // Memastikan $qrCodeData tidak null dan memiliki kunci yang diperlukan
        if (!is_null($qrCodeData) && isset($qrCodeData['ID']) && isset($qrCodeData['participant_id'])) {
            // Logging informasi data QR code
            Log::info('QR Code Data: ' . print_r($qrCodeData, true));

            // Mencocokkan data QR code dengan data dalam database logs_undangan_pengunjung
            $matchingData = logs_undangan_pengunjung::where('undangan_id', $qrCodeData['ID'])
                ->where('pengunjung_id', $qrCodeData['participant_id'])
                ->first();

            // Jika data cocok ditemukan di logs_undangan_pengunjung
            if ($matchingData) {
                $now = Carbon::now(new DateTimeZone('Asia/Jakarta'));
                $checkInStatus = '';

                // Jika check_in belum ada
                if (!$matchingData->check_in) {
                    // Update check_in dengan timestamp sekarang
                    $matchingData->update([
                        'check_in' => $now,
                    ]);
                    $checkInStatus = 'Check-in berhasil';
                    return response()->json([
                        'status' => 200,
                        'message' => $checkInStatus,
                        'check_in_status' => 'Check-in Visitor',
                        'data' => $qrCodeData
                    ]);
                } // Jika check_in sudah ada tetapi check_out belum ada
                elseif (!$matchingData->check_out) {
                    // Update check_out dengan timestamp sekarang
                    $matchingData->update([
                        'check_out' => $now,
                    ]);
                    $checkInStatus = 'Check-out berhasil';
                    return response()->json([
                        'status' => 200,
                        'message' => $checkInStatus,
                        'check_in_status' => 'Check-out Visitor',
                        'data' => $qrCodeData
                    ]);
                } else {
                    // Jika kedua check_in dan check_out sudah ada
                    $checkInStatus = 'QR code sudah terpakai';
                    return response()->json([
                        'status' => 400,
                        'message' => $checkInStatus,
                        'check_in_status' => 'Check-out Visitor',
                        'data' => $qrCodeData
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data QR code tidak cocok',
                    'check_in_status' => 'Unknown'
                ]);
            }
        } else {
            // Memberikan respons error jika data QR code tidak lengkap atau tidak valid
            return response()->json([
                'status' => 400,
                'message' => 'Data QR code tidak lengkap atau tidak valid',
                'check_in_status' => 'Unknown'
            ]);
        }
    } catch (\Exception $e) {
        // Logging informasi kesalahan yang terjadi
        Log::error('Error in scanQrCode: ' . $e->getMessage());

        // Memberikan respons error jika terjadi kesalahan
        return response()->json([
            'status' => 500,
            'message' => 'Terjadi kesalahan.',
            'check_in_status' => 'Unknown'
        ]);
    }
}

private function checkAllCompleted($undanganId)
{
    // Memeriksa apakah semua entri dalam logs_undangan_pengunjung untuk undangan tertentu sudah memiliki check_in dan check_out
    $allCompleted = logs_undangan_pengunjung::where('undangan_id', $undanganId)
        ->whereNull('check_out')
        ->doesntExist();

    return $allCompleted;
}




    public function index_scanQrCode(){
        return view('entry_point/checkin_out');
    }

    public function index_riwayat(){
        $undangan = UndanganPengunjung::whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])->get();
        return view('entry_point/riwayatEP', compact('undangan'));
    }

    public function index_IT(){
        $undangan = UndanganPengunjung::where('status', 'Diterima')->with('divisi')->get();
        $divisis = Divisi::all();
        return view('entry_point/informasitamuEP', compact('undangan','divisis'));
    }

    public function index_profile_entry(){

        $Entry = Auth::guard('entry_point')->user();

        return view('entry_point.profile_entrypoint', compact('Entry'));
    }

    public function editPasswordForm()
    {
        return view('entry_point.edit_password');
    }

    public function updatePassword(Request $request)
{
    $entry_point = Auth::guard('entry_point')->user(); // Mengambil admin yang sedang login

    // Validasi input
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|different:current_password',
        'new_password_confirmation' => 'same:new_password',
    ]);

    // Periksa apakah password saat ini sesuai
    if (!Hash::check($request->current_password, $entry_point->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Hash password baru
    $entry_point->password = Hash::make($request->new_password);

    // Simpan perubahan
    $entry_point->save();

    // Simpan pesan sukses ke dalam session
    session()->flash('custom_success', 'Password Berhasil Diperbaharui.');
    return redirect()->route('profile_entry.show')->with('success', 'Password Berhasil Diperbaharui.');
}

public function checkQrStatus(Request $request)
{
    try {
        // Mendapatkan data QR code yang dipindai dari permintaan (request)
        $qrCodeData = json_decode($request->input('qr_code'), true);

        // Memastikan $qrCodeData tidak null dan memiliki kunci yang diperlukan
        if (!is_null($qrCodeData) && isset($qrCodeData['ID']) && isset($qrCodeData['participant_id'])) {
            // Mencocokkan data QR code dengan data dalam database logs_undangan_pengunjung
            $matchingData = logs_undangan_pengunjung::where('undangan_id', $qrCodeData['ID'])
                ->where('pengunjung_id', $qrCodeData['participant_id'])
                ->first();

            // Jika data cocok ditemukan di logs_undangan_pengunjung
            if ($matchingData) {
                // Periksa status check-in dan check-out
                $checkInStatus = $matchingData->check_in ? 'Check-in' : 'Check-out';
                return response()->json([
                    'status' => 200,
                    'check_in_status' => $checkInStatus,
                    'data' => [
                        'check_in' => $matchingData->check_in,
                        'check_out' => $matchingData->check_out
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data QR code tidak cocok',
                    'check_in_status' => 'Unknown',
                    'data' => [
                        'check_in' => null,
                        'check_out' => null
                    ]
                ]);
            }
        } else {
            // Memberikan respons error jika data QR code tidak lengkap atau tidak valid
            return response()->json([
                'status' => 400,
                'message' => 'Data QR code tidak lengkap atau tidak valid',
                'check_in_status' => 'Unknown',
                'data' => [
                    'check_in' => null,
                    'check_out' => null
                ]
            ]);
        }
    } catch (\Exception $e) {
        // Logging informasi kesalahan yang terjadi
        Log::error('Error in checkQrStatus: ' . $e->getMessage());

        // Memberikan respons error jika terjadi kesalahan
        return response()->json([
            'status' => 500,
            'message' => 'Terjadi kesalahan.',
            'check_in_status' => 'Unknown',
            'data' => [
                'check_in' => null,
                'check_out' => null
            ]
        ]);
    }
}

    
}
