<?php

namespace App\Http\Controllers;

use App\Models\lokasi;
use Illuminate\Http\Request;

class lokasiController extends Controller{

    public function index_lokasi(){
        $lokasis = Lokasi::all();
        $title = "Lokasi"; 
        return view('admin/lokasi_admin', compact('lokasis', 'title'));
    }
    

    public function index_tambah_lokasi(){
        return view('admin/tambah_lokasi');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ruangan' => 'required',
            'lantai' => 'required',
        ]);

        $lokasi = new Lokasi();
        $lokasi->ruangan = $request->ruangan;
        $lokasi->lantai = $request->lantai;
        $lokasi->save();

        return redirect('/lokasi_admin')->with('success', 'Lokasi berhasil ditambahkan!');
    }

}