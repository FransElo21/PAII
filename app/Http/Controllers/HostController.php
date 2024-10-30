<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;
use App\Models\Host;
use App\Models\logs_undangan_pengunjung;
use App\Models\lokasi;
use App\Models\Pengunjung;
use App\Models\pengunjung_undangan_host;
use App\Models\undangan_host;
use App\Models\UndanganPengunjung;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HostController extends Controller
{
    public function index_host(){
        // Mendapatkan ID host yang sedang login
        $host_id = auth('host')->id();
    
        // Mendapatkan jumlah undangan masuk
        $undangan_masuk = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Menunggu')
            ->count();
    
        // Mendapatkan jumlah undangan yang akan datang
        $undangan_akan_datang = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Diterima')
            ->count();
   
            $currentDate = Carbon::now()->toDateString();
            $hostId = Auth::id();

            $logs_kunjungan_check_in_out = logs_undangan_pengunjung::where(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_in', $currentDate)
                          ->whereHas('undangan_pengunjung', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->orWhere(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_out', $currentDate)
                          ->whereHas('undangan_pengunjung', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->count();

                $groupMember_kunjungan_check_in_out = GroupMember::where(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_in', $currentDate)
                          ->whereHas('undangan', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->orWhere(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_out', $currentDate)
                          ->whereHas('undangan', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->count();
            
            $hostKunjungan_check_in_out = pengunjung_undangan_host::where(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_in', $currentDate)
                          ->whereHas('undanganHost', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->orWhere(function ($query) use ($currentDate, $hostId) {
                    $query->whereDate('check_out', $currentDate)
                          ->whereHas('undanganHost', function ($query) use ($hostId) {
                              $query->where('host_id', $hostId);
                          });
                })
                ->count();
            
        $total_kunjungan_check_in_out = $logs_kunjungan_check_in_out + $groupMember_kunjungan_check_in_out + $hostKunjungan_check_in_out;
            
    
        // Mendapatkan jumlah undangan yang kadaluarsa
        $undangan_kadaluarsa = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Kadaluarsa')
            ->count();

        $undangan_masukdata = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Menunggu')
            ->get();

        $undangan_akan_datangdata = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Diterima')
            ->get();

        $undangan_kadaluarsadata = UndanganPengunjung::where('host_id', $host_id)
            ->where('status', 'Kadaluarsa')
            ->get();

            $currentDate = now()->toDateString();
            $hostId = auth()->id();
            
            $registers = logs_undangan_pengunjung::whereHas('undangan_pengunjung', function ($query) use ($hostId) {
                    $query->where('host_id', $hostId);
                })->get()->map(function($register) {
                    return [
                        'id' => $register->id,
                        'name' => $register->pengunjung->namaLengkap,
                        'check_in' => $register->check_in,
                        'check_out' => $register->check_out,
                        'subject' => $register->undangan_pengunjung->subject,
                        'status' => $register->undangan_pengunjung->status,
                        'Host' => $register->undangan_pengunjung->host->nama
                    ];
                })->filter(function($register) {
                    return $register['check_in'] || $register['check_out'];
                });
            
            $nonRegisters = GroupMember::whereHas('undangan', function ($query) use ($hostId) {
                    $query->where('host_id', $hostId);
                })->get()->map(function($nonRegister) {
                    return [
                        'id' => $nonRegister->id,
                        'name' => $nonRegister->name,
                        'check_in' => $nonRegister->check_in,
                        'check_out' => $nonRegister->check_out,
                        'subject' => $nonRegister->undangan->subject,
                        'status' => $nonRegister->undangan->status,
                        'Host' => $nonRegister->undangan->host->nama
                    ];
                })->filter(function($nonRegister) {
                    return $nonRegister['check_in'] || $nonRegister['check_out'];
                });
            
            $hostRegisters = pengunjung_undangan_host::whereHas('undanganHost', function ($query) use ($hostId) {
                    $query->where('host_id', $hostId);
                })->get()->map(function($hostRegister) {
                    return [
                        'id' => $hostRegister->id,
                        'name' => $hostRegister->nama,
                        'check_in' => $hostRegister->waktu_temu,
                        'check_out' => $hostRegister->waktu_kembali,
                        'subject' => $hostRegister->undanganHost->subject,
                        'status' => $hostRegister->undanganHost->status,
                        'Host' => $hostRegister->undanganHost->host->nama
                    ];
                })->filter(function($hostRegister) {
                    return $hostRegister['check_in'] || $hostRegister['check_out'];
                });
            
        $combinedDatacheck = $registers->merge($nonRegisters)->merge($hostRegisters);            

    
        return view('host/berandahost', compact('undangan_masuk', 'undangan_akan_datang', 'undangan_kadaluarsa', 'undangan_masukdata', 'total_kunjungan_check_in_out','undangan_akan_datangdata', 'undangan_kadaluarsadata', 'combinedDatacheck'));
    }    

    // public function index_accept(Request $request) {
    //     $undangan_id = $request->undangan_id;
    //     $undangan = UndanganPengunjung::findOrFail($undangan_id);
    //     $lokasis = Lokasi::orderBy('created_at', 'desc')->get(); // Mengambil data lokasi berdasarkan created_at terbaru
    //     return view('host/konfirmasi_undangan', compact('undangan', 'lokasis'));
    // }
    
    
    // public function acceptUndangan(Request $request, $id) {
    //     try {
    //         // Temukan undangan berdasarkan ID atau gagal jika tidak ditemukan
    //         $undangan = UndanganPengunjung::findOrFail($id);
    
    //         // Update status undangan menjadi 'diterima'
    //         $undangan->update([
    //             'status' => 'diterima',
    //         ]);
    
    //         // Mengumpulkan detail undangan
    //         $details = [
    //             'ID' => $undangan->id,
    //             'Nama' => $undangan->pengunjung->namaLengkap, // Asumsikan ada relasi pengunjung
    //             'Tanggal' => $undangan->waktu_temu,
    //             'Lokasi' => $undangan->ruangan,
    //             'Pesan' => $undangan->keterangan,
    //         ];
    
    //         // Mengonversi array detail undangan menjadi string JSON
    //         $detailsJson = json_encode($details);
    
    //         // Tentukan jalur direktori untuk menyimpan QR code
    //         $directory = storage_path('app/public/qr');
    
    //         // Jika direktori tidak ada, buat direktori tersebut
    //         if (!is_dir($directory)) {
    //             if (!mkdir($directory, 0777, true)) {
    //                 return redirect()->back()->with('error', 'Gagal membuat direktori untuk QR code.');
    //             }
    //         }
    
    //         // Tentukan jalur file untuk menyimpan QR code
    //         $qrFileName = 'qrimage-' . $id . '-' . $undangan->id . '.png';
    //         $qrImagePath = $directory . '/' . $qrFileName;
    
    //         // Generate QR code dengan detail undangan
    //         $qrCode = QrCode::format('png')->size(500)->generate($detailsJson);
    
    //         // Simpan QR code ke file
    //         if (file_put_contents($qrImagePath, $qrCode) === false) {
    //             return redirect()->back()->with('error', 'Gagal menyimpan QR code.');
    //         }
    
    //         // Redirect kembali dengan pesan sukses
    //         // return redirect('konfirmasi_kunjungan.show')->with('success', 'Undangan telah diterima.');
    //         session()->flash('konfirmasi_berhasil', true);
    //         return Redirect::route('konfirmasi_kunjungan.show')->with('konfirmasi_berhasil', 'Berhasil konfirmasi');;
    
    //     } catch (\Exception $e) {
    //         // Logging error message
    //         Log::error('Error accepting undangan: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menerima undangan.');
    //     }
    // }

    public function acceptUndangan(Request $request, $id)
{
    try {
        // Temukan undangan berdasarkan ID atau gagal jika tidak ditemukan
        $undangan = UndanganPengunjung::findOrFail($id);

        // Perbarui status undangan menjadi 'Diterima'
        $undangan->update(['status' => 'Diterima']);

        // Tentukan jalur direktori untuk menyimpan kode QR
        $directory = storage_path('app/public/qr');

        // Jika direktori tidak ada, buat
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                return redirect()->back()->with('error', 'Gagal membuat direktori untuk kode QR.');
            }
        }

        // Kirim kode QR ke WhatsApp pengunjung menggunakan Fonnte
        $groupMembers = $undangan->groupMembers()->get();
        $messageTemplate = "Hallo %s!\n\nSalam sejahtera, kami dari VMS (Visitor Management System).\n\nUndangan Anda telah diterima. Silakan scan QR Code berikut ini:\n\nTerima kasih.";

        // Token API Fonnte Anda
        $token = env('FONNTE_API_TOKEN');

        foreach ($groupMembers as $member) {
            $recipients[] = [
                'name' => $member->name,
                'phone' => $member->phone,
                'nik' => $member->nik,
                'check_in' => $member->check_in,
                'check_out' => $member->check_out,
                'participant_id' => $member->uuid, // Menggunakan nilai UUID dari tabel
            ];
        }        

        // Tambahkan pengunjung utama ke dalam penerima
        $recipients[] = [
            'name' => $undangan->pengunjung->namaLengkap,
            'phone' => $undangan->pengunjung->nomor_telepon,
            'nik' => null,
            'check_in' => null,
            'check_out' => null,
            'participant_id' => $undangan->pengunjung->id, // Tambahkan ID pengunjung
        ];

        $lokasiDetail = "{$undangan->lokasi->ruangan},{$undangan->lokasi->lantai}";
        $fotoProfil = trim($undangan->pengunjung->foto_profil, '/');

        foreach ($recipients as $recipient) {
            // Collect invitation details specific to the recipient
            $details = [
                'ID' => $undangan->id,
                'Subjek' => $undangan->subject,
                'Nama' => $recipient['name'],
                'Kunjungan Dari' => $undangan->kunjungan_dari,
                'Waktu Temu' => $undangan->waktu_temu,
                'Waktu Kembali' => $undangan->waktu_kembali,
                'Host' => $undangan->host->nama,
                'Lokasi' => $lokasiDetail,
                'Pesan' => $undangan->keterangan,
                'Jenis Undangan' => $undangan->type,
                'Foto Profil' => asset($fotoProfil), // URL foto profil yang benar
                'Member NIK' => $recipient['nik'],
                'Member Check-In' => $recipient['check_in'],
                'Member Check-Out' => $recipient['check_out'],
                'participant_id' => $recipient['participant_id'], // Tambahkan ID partisipan (anggota grup atau pengunjung)
            ];

            // Convert invitation details array to JSON string
            $detailsJson = json_encode($details);

            // Determine the file path to save the QR code
            $qrFileName = 'qrimage-' . $id . '-' . md5($recipient['phone']) . '.png';
            $qrImagePath = $directory . '/' . $qrFileName;

            // Generate QR code with invitation details
            $qrCode = QrCode::format('png')->size(500)->generate($detailsJson);

            // Save the QR code to file
            if (file_put_contents($qrImagePath, $qrCode) === false) {
                return redirect()->back()->with('error', 'Gagal menyimpan kode QR.');
            }

            $phoneNumber = $recipient['phone'];
            $message = sprintf($messageTemplate, $recipient['name']);

            // Check if the image file exists
            if (!file_exists($qrImagePath)) {
                return redirect()->back()->with('error', 'File kode QR tidak ada');
            }

            // Create a CURLFile object for the image
            $imageFile = curl_file_create($qrImagePath, mime_content_type($qrImagePath), basename($qrImagePath));

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target' => $phoneNumber,
                    'message' => $message,
                    'file' => $imageFile // Attach the image file
                ],
                CURLOPT_HTTPHEADER => [
                    "Authorization: $token"
                ],
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                curl_close($curl);
                return redirect()->back()->with('error', "Kesalahan cURL: $error_msg");
            }

            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_code != 200) {
                return redirect()->back()->with('error', "API mengembalikan kode status $http_code. Respons: $response");
            }
        }

        // Alihkan kembali dengan pesan sukses
        session()->flash('konfirmasi_berhasil', true);
        return Redirect::route('konfirmasi_kunjungan.show')->with('konfirmasi_berhasil', 'Berhasil konfirmasi');

    } catch (\Exception $e) {
        // Logging pesan kesalahan
        Log::error('Kesalahan saat menerima undangan: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menerima undangan.');
    }
}

    
    public function rejectUndangan(Request $request, $id)
    {
        try {
            // Temukan undangan berdasarkan ID atau gagal jika tidak ditemukan
            $undangan = UndanganPengunjung::findOrFail($id);

            // Update status undangan menjadi 'ditolak' dan simpan alasan penolakan
            $undangan->update([
                'status' => 'Ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);

            // Redirect kembali dengan pesan sukses
            return Redirect::route('konfirmasi_kunjungan.show')->with('success', 'Berhasil Menolak');
            
        } catch (\Exception $e) {
            // Logging error message
            Log::error('Error rejecting undangan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak undangan.');
        }
    }

    public function index_penolakan($id){

        $undangan = UndanganPengunjung::find($id); // Gantilah ini dengan cara Anda mendapatkan data undangan
        return view('host/alasan_penolakan', compact('undangan'));
    }

    public function scanQrCode(Request $request) {
        try {
            // Decode JSON dari QR code
            $details = json_decode($request->input('qr_data'), true);
    
            if (!$details || !isset($details['ID'])) {
                return response()->json(['error' => 'Invalid QR code data'], 400);
            }
    
            // Temukan undangan berdasarkan ID
            $undangan = UndanganPengunjung::find($details['ID']);
    
            if (!$undangan) {
                return response()->json(['error' => 'Undangan tidak ditemukan'], 404);
            }
    
            // Kembalikan detail undangan
            return response()->json([
                'ID' => $undangan->id,
                'Nama' => $undangan->pengunjung->namaLengkap,
                'Tanggal' => $undangan->waktu_temu,
                'Lokasi' => $undangan->ruangan,
                'Pesan' => $undangan->keterangan,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat memproses QR code'], 500);
        }
    }
    
    public function index_buatkunjungan_host(){
        $pengunjung = Pengunjung::all();
        return view('host/buat_kunjungan_host', compact('pengunjung'));
    }

    public function index_konfirmasi_kunjungan()
    {
        // Mengambil data undangan yang terkait dengan host yang sedang login
        $hostId = Auth::guard('host')->id();
        $undangans = UndanganPengunjung::where('host_id', $hostId)
                                        ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan created_at terbaru
                                        ->get();

        return view('host.konfirmasi_kunjungan', compact('undangans'));
    }

    public function index_riwayat_host()
{
    // Mengambil ID host yang sedang login
    $hostId = Auth::guard('host')->user()->id;

    // Mengambil dan menggabungkan data dari tiga model
    $registers = logs_undangan_pengunjung::whereHas('undangan_pengunjung', function ($query) use ($hostId) {
        $query->where('status', 'Selesai')
            ->where('host_id', $hostId);
    })->get()->map(function($register) {
        return [
            'id' => $register->id, // Add ID here
            'name' => $register->pengunjung->namaLengkap,
            'check_in' => $register->check_in,
            'check_out' => $register->check_out,
            'subject' => $register->undangan_pengunjung->subject,
            'status' => $register->undangan_pengunjung->status,
            'Host' => $register->undangan_pengunjung->host->nama
        ];
    });

    $nonRegisters = GroupMember::whereHas('undangan', function ($query) use ($hostId) {
        $query->where('status', 'Selesai')
            ->where('host_id', $hostId);
    })->get()->map(function($nonRegister) {
        return [
            'id' => $nonRegister->id, // Add ID here
            'name' => $nonRegister->name,
            'check_in' => $nonRegister->check_in,
            'check_out' => $nonRegister->check_out,
            'subject' => $nonRegister->undangan->subject,
            'status' => $nonRegister->undangan->status,
            'Host' => $nonRegister->undangan->host->nama
        ];
    });

    $hostRegisters = pengunjung_undangan_host::whereHas('undanganHost', function ($query) use ($hostId) {
        $query->where('status', 'Selesai')
            ->where('host_id', $hostId);
    })->get()->map(function($hostRegister) {
        return [
            'id' => $hostRegister->id, // Add ID here
            'name' => $hostRegister->name,
            'check_in' => $hostRegister->check_in,
            'check_out' => $hostRegister->check_out,
            'subject' => $hostRegister->undanganHost->subject,
            'status' => $hostRegister->undanganHost->status,
            'Host' => $hostRegister->undanganHost->host->nama
        ];
    });

    // Menggabungkan semua riwayat ke dalam satu koleksi
    $combinedData = $registers->merge($nonRegisters)->merge($hostRegisters);

    // Mengambil dan menggabungkan undangan pengunjung dan undangan host, kemudian diurutkan berdasarkan waktu terbaru
    $allUndangan = UndanganPengunjung::where('host_id', $hostId)
        ->whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])
        ->orderBy('updated_at', 'desc')
        ->get()
        ->merge(
            undangan_host::where('host_id', $hostId)
                ->whereIn('status', ['Ditolak', 'Kadaluarsa', 'Selesai'])
                ->orderBy('updated_at', 'desc')
                ->get()
        );

    // Mengirimkan data gabungan dan undangan ke view, diurutkan berdasarkan waktu terbaru
    return view('host.riwayat_host', compact('combinedData', 'allUndangan'));
}

    public function show($id)
    {
        $undangan = UndanganPengunjung::findOrFail($id); // Mendapatkan undangan berdasarkan ID
        $groupMembers = GroupMember::where('undangan_id', $id)->select('name', 'email', 'phone', 'nik')->get()->toArray(); // Mendapatkan daftar nama pengunjung
        $nrVisitor = count($groupMembers) + 1;

        return view('host/detailundangan', compact('undangan', 'nrVisitor', 'groupMembers'));
    }

    public function store_undangan_host(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'subject' => 'required|string|max:255',
        'keperluan' => 'required|string',
        'kunjungan_dari' => 'required|string|max:255',
        'keterangan' => 'required|string|max:255',
        'waktu_temu' => 'required|date',
        'waktu_kembali' => 'nullable|date',
        'visitors' => 'required|array',
        'visitors.*.name' => 'required|string|max:255',
        'visitors.*.email' => 'required|email|max:255',
        'visitors.*.phone' => 'required|string|regex:/^\+62\d{9,15}$/',
        'visitors.*.NIK' => 'required|string|max:16',
    ]);

    // Ambil host yang sedang login
    $host = Host::find(Auth::guard('host')->id());
    if (!$host || !$host->lokasi_id) {
        return redirect()->back()->withErrors(['host_id' => 'Host tidak memiliki lokasi yang terkait.']);
    }

    // Tambahkan informasi host ke dalam request
    $request->merge([
        'host_id' => $host->id,
        'lokasi_id' => $host->lokasi_id,
        'status' => 'Diundang', // Atau status lain yang sesuai
    ]);

    // Buat undangan
    $undangan = undangan_host::create($request->only([
        'subject', 'keperluan', 'kunjungan_dari', 'keterangan', 'waktu_temu', 'waktu_kembali', 'host_id', 'lokasi_id', 'status'
    ]));

    // Ambil semua penerima undangan dari tabel undangan_pengunjung_host
    $recipients = pengunjung_undangan_host::select('name', 'phone', 'NIK', 'uuid')->get();

    // Determine the directory path for saving the QR codes
    $directory = storage_path('app/public/qr');

    // If directory does not exist, create it
    if (!is_dir($directory)) {
        if (!mkdir($directory, 0777, true)) {
            return redirect()->back()->with('error', 'Failed to create directory for QR code.');
        }
    }

    // Your Fonnte API token
    $token = env('FONNTE_API_TOKEN');
    $messageTemplate = "Halo %s, Anda diundang untuk melakukan kunjungan. Berikut adalah QR code untuk undangan Anda.";

    // Tambahkan visitors ke dalam undangan dan kirim QR code
    foreach ($recipients as $recipient) {
        // Collect invitation details specific to the recipient
        $details = [
            'ID' => $undangan->id,
            'Visitor ID' => $recipient->uuid, // Menambahkan ID pengunjung undangan
            'Subject' => $undangan->subject,
            'Nama' => $recipient->name,
            'Kunjungan Dari' => $undangan->kunjungan_dari,
            'Waktu Temu' => $undangan->waktu_temu,
            'Waktu Kembali' => $undangan->waktu_kembali,
            'Host' => $host->nama,
            'Lokasi' => $host->lokasi->ruangan,
            'Pesan' => $undangan->keterangan,
            'Jenis Undangan' => $undangan->type,
            'Member NIK' => $recipient->NIK,
        ];

        // Convert invitation details array to JSON string
        $detailsJson = json_encode($details);

        // Determine the file path to save the QR code
        $qrFileName = 'qrimage-' . $undangan->id . '-' . $recipient->uuid . '.png';
        $qrImagePath = $directory . '/' . $qrFileName;

        // Generate QR code with invitation details
        $qrCode = QrCode::format('png')->size(500)->generate($detailsJson);

        // Save the QR code to file
        if (file_put_contents($qrImagePath, $qrCode) === false) {
            return redirect()->back()->with('error', 'Failed to save QR code.');
        }

        // Mengambil nomor telepon penerima
        $phoneNumber = $recipient->phone;

        // Membuat pesan untuk penerima
        $message = sprintf($messageTemplate, $recipient->name);

        // Create a CURLFile object for the image
        $imageFile = curl_file_create($qrImagePath, mime_content_type($qrImagePath), basename($qrImagePath));

        // Inisialisasi cURL
        $curl = curl_init();

        // Set options for the cURL transfer
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $phoneNumber,
                'message' => $message,
                'file' => $imageFile // Attach the image file
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        // Execute the cURL session
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return redirect()->back()->with('error', "cURL Error: $error_msg");
        }

        // Get the HTTP response code
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($curl);

        // Check if the HTTP response code is not 200 (OK)
        if ($http_code != 200) {
            return redirect()->back()->with('error', "API returned status code $http_code. Response: $response");
        }
    }

    // Redirect dengan pesan sukses
    return redirect()->route('buatkunjungan_host.show')->with('buat_undangan_berhasil', true);
}


    public function edit_host()
    {
        $user = Auth::guard('host')->user();
        return view('host/edit_profile_host', compact('user'));
    }

    public function update_host(Request $request)
    {
        $user = Auth::guard('host')->user();
        // Perbarui profil pengguna
        $user = \App\Models\Host::find($user->id); // Mengonversi menjadi instance model User yang sebenarnya
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
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
        return Redirect::route('profile_host')->with('upsuccess', 'Profil berhasil diperbaharui');
    }
    
    
}    
