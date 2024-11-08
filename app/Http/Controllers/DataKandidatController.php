<?php

namespace App\Http\Controllers;

use App\Models\DataKandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataKandidatController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');  // Pastikan hanya admin yang bisa mengakses controller ini
    }

    // Create data kandidat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kandidat' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'umur_kandidat' => 'required|integer',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'latar_belakang' => 'required|string',
            'pencapaian' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        if ($request->hasFile('foto_profile')) {
            $validated['foto_profile'] = $request->file('foto_profile')->store('foto_kandidat', 'public');
        }

        $dataKandidat = DataKandidat::create($validated);

        return response()->json($dataKandidat, 201);
    }

    // Read all data kandidat
    public function index()
    {
        $dataKandidat = DataKandidat::all();
        return response()->json($dataKandidat);
    }

    // Update data kandidat
    public function update(Request $request, $id)
    {
        $dataKandidat = DataKandidat::findOrFail($id);

        $validated = $request->validate([
            'nama_kandidat' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'umur_kandidat' => 'required|integer',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'latar_belakang' => 'required|string',
            'pencapaian' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($dataKandidat->foto_profile) {
                Storage::delete('public/' . $dataKandidat->foto_profile);
            }
            $validated['foto_profile'] = $request->file('foto_profile')->store('foto_kandidat', 'public');
        }

        $dataKandidat->update($validated);

        return response()->json($dataKandidat);
    }

    // Delete data kandidat
    public function destroy($id)
    {
        $dataKandidat = DataKandidat::findOrFail($id);

        if ($dataKandidat->foto_profile) {
            Storage::delete('public/' . $dataKandidat->foto_profile);
        }

        $dataKandidat->delete();

        return response()->json(['message' => 'Data Kandidat deleted successfully']);
    }
}
