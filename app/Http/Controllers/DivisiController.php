<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

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
            'nama_divisi' => 'required|string|max:255|unique:divisi',
        ]);

        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
        ]);

        return redirect()->route('divisi.show')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisi,nama_divisi,'.$id,
        ]);

        $divisi = Divisi::findOrFail($id);
        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
        ]);

        return redirect()->route('divisi.show')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('divisi.show')->with('success', 'Divisi berhasil dihapus.');
    }
}
