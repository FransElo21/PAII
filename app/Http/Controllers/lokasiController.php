<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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


        $existingLocation = Lokasi::where('ruangan', $request->ruangan)
        ->where('lantai', $request->lantai)
        ->first();

        if ($existingLocation) {
            // Jika sudah ada, kembalikan pesan kesalahan
            // session()->flash('error_tambahlokasi', true);
            // return redirect()->back()->with('error_tambahlokasi', 'Kombinasi ruangan dan lantai sudah ada.');
            return Redirect::route('lokasi.show')->with('duplikat', 'Kombinasi ruangan dan lantai sudah ada.');
        }

        $lokasi = new Lokasi();
        $lokasi->ruangan = $request->ruangan;
        $lokasi->lantai = $request->lantai;
        $lokasi->save();

        session()->flash('success_tambahlokasi', true);
        return redirect('/lokasi_admin')->with('success_tambahlokasi', 'Lokasi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $lokasi = lokasi::findOrFail($id);
        $lokasi->delete();

        session()->flash('success_hapuslokasi', true);
        return redirect()->route('lokasi.show')->with('success_hapuslokasi', 'Lokasi berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruangan' => 'required|unique:lokasi,ruangan,' . $id . ',id,lantai,' . $request->lantai,
            'lantai' => 'required',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update($request->all());

        return redirect()->route('lokasi.show')->with('success_update_lokasi', 'Lokasi berhasil diperbarui!');
    }

    public function index_edit($id)
    {
        $lokasis = Lokasi::findOrFail($id);
        return view('admin/edit_lokasi', compact('lokasis'));
    }
}

