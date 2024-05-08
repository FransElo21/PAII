<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Host;
use App\Models\lokasi;
use App\Models\UndanganPengunjung;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    public function index_host(){
        $undangans = UndanganPengunjung::where('host_id', Auth::guard('host')->user()->id)->where('status', 'menunggu')->get();
        $data = [
            "title" => "Dashboard"
        ];
        return view('host/berandahost', compact('undangans'))->with($data);
    }
    
    public function index_accept(Request $request) {
        $undangan_id = $request->undangan_id;
        $undangan = UndanganPengunjung::findOrFail($undangan_id);
        $lokasis = lokasi::all();
        return view('host/konfirmasi_undangan', compact('undangan','lokasis'));
    }
    
    public function acceptUndangan(Request $request, $id) {
        $undangan = UndanganPengunjung::findOrFail($id);
        $undangan->update([
            'status' => 'diterima',
            'waktu' => $request->waktu, 
            'lokasi' => $request->lokasi 
        ]);
        return redirect()->back()->with('success', 'Undangan telah diterima.');
    }
    
    public function rejectUndangan(Request $request) {
        $undangan = UndanganPengunjung::findOrFail($request->undangan_id);
        $undangan->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Undangan telah ditolak.');
    }
    
}
