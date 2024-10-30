<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DivisiController extends Controller
{
    public function index_divisi() {
        $divisis = Divisi::all();
        return view('admin.admin_divisi', compact('divisis'), [
            "title" => "Divisi"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255'
        ]);

        $divisi = Divisi::where('nama_divisi', $request->nama_divisi)->first();

        if ($divisi) {
            // Jika divisi dengan nama yang sama sudah ada
            session()->flash('error_tambahdivisi', true);
            // return redirect()->back()->with('error_tambahdivisi', 'Divisi dengan nama yang sama sudah ada.');'
            return Redirect::route('divisi.show')->with('duplikat', 'Divisi dengan nama yang sama sudah ada.');
        }

        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
        ]);

        session()->flash('success_tambahdivisi', true);
        return redirect()->route('divisi.show')->with('success_tambahdivisi', 'Divisi berhasil ditambahkan.');
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_divisi' => 'required|string|max:255|unique:divisi,nama_divisi,'.$id,
    //     ]);

    //     $divisi = Divisi::findOrFail($id);
    //     $divisi->update([
    //         'nama_divisi' => $request->nama_divisi,
    //     ]);

    //     return redirect()->route('divisi.show')->with('success', 'Divisi berhasil diperbarui.');
    // }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        session()->flash('success_hapusdivisi', true);
        return redirect()->route('divisi.show')->with('success_hapusdivisi', 'Divisi berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->nama_divisi = $request->input('nama_divisi');
        $divisi->save();

        return redirect()->route('divisi.show')->with('success_update_divisi', 'Divisi berhasil diperbarui!');
    }

    public function getDivisions()
    {
        $divisions = Divisi::all();
        return response()->json(['divisions' => $divisions]);
    }

    public function filterDataByDivision(Request $request)
    {
        $divisionId = $request->input('division_id');
        $data = DataModel::where('division_id', $divisionId)->get();
        return response()->json(['data' => $data]);
    }
}
