<?php

namespace App\Http\Controllers;

use App\Models\PosisiKandidat;
use Illuminate\Http\Request;

class PosisiKandidatController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');  // Pastikan hanya admin yang bisa mengakses controller ini
    }

    // Create posisi kandidat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_posisi' => 'required|string|max:255',
        ]);

        $posisiKandidat = PosisiKandidat::create($validated);

        return response()->json($posisiKandidat, 201);
    }

    // Read all posisi kandidat
    public function index()
    {
        $posisiKandidat = PosisiKandidat::all();
        return response()->json($posisiKandidat);
    }

    // Update posisi kandidat
    public function update(Request $request, $id)
    {
        $posisiKandidat = PosisiKandidat::findOrFail($id);

        $validated = $request->validate([
            'nama_posisi' => 'required|string|max:255',
        ]);

        $posisiKandidat->update($validated);

        return response()->json($posisiKandidat);
    }

    // Delete posisi kandidat
    public function destroy($id)
    {
        $posisiKandidat = PosisiKandidat::findOrFail($id);
        $posisiKandidat->delete();

        return response()->json(['message' => 'Posisi Kandidat deleted successfully']);
    }
}
