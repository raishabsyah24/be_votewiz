<?php

namespace App\Http\Controllers;

use App\Models\Pemilihan;
use Illuminate\Http\Request;

class PemilihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');  // Membatasi akses hanya untuk role admin
    }

    // Create pemilihan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilihan' => 'required|string|max:255',
            'tanggal_pemilihan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $pemilihan = Pemilihan::create($validated);

        return response()->json($pemilihan, 201);
    }

    // Read all pemilihan
    public function index()
    {
        $pemilihan = Pemilihan::all();
        return response()->json($pemilihan);
    }

    // Update pemilihan
    public function update(Request $request, $id)
    {
        $pemilihan = Pemilihan::findOrFail($id);

        $validated = $request->validate([
            'nama_pemilihan' => 'required|string|max:255',
            'tanggal_pemilihan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $pemilihan->update($validated);

        return response()->json($pemilihan);
    }

    // Delete pemilihan
    public function destroy($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);
        $pemilihan->delete();

        return response()->json(['message' => 'Pemilihan deleted successfully']);
    }
}
