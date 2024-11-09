<?php

namespace App\Http\Controllers;

use App\Models\PemilihanKandidat;
use App\Models\DataKandidat;
use App\Models\PosisiKandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemilihanKandidatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        $pemilihanKandidats = PemilihanKandidat::with('kandidat', 'posisi', 'nama_pemilihan')->get();
        return response()->json($pemilihanKandidats);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'no_urut' => 'required|integer',
            'kandidat_id' => 'required|exists:data_kandidats,id',
            'posisi_id' => 'required|exists:posisi_kandidats,id',
            'slogan' => 'required|string',
            'visi_misi' => 'required|file|mimes:pdf,doc,docx',
            'nama_pemilihan_id' => 'required|exists:pemilihans,id',
        ]);

        $visiMisiPath = $request->file('visi_misi')->store('visi_misi_files');

        $pemilihanKandidat = PemilihanKandidat::create([
            'no_urut' => $request->no_urut,
            'kandidat_id' => $request->kandidat_id,
            'posisi_id' => $request->posisi_id,
            'slogan' => $request->slogan,
            'visi_misi_path' => $visiMisiPath,
            'nama_pemilihan_id' => $request->nama_pemilihan_id,
        ]);

        return response()->json($pemilihanKandidat, 201);
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $pemilihanKandidat = PemilihanKandidat::with('kandidat', 'posisi', 'nama_pemilihan')->findOrFail($id);
        return response()->json($pemilihanKandidat);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $pemilihanKandidat = PemilihanKandidat::findOrFail($id);

        $request->validate([
            'no_urut' => 'sometimes|integer',
            'kandidat_id' => 'sometimes|exists:data_kandidats,id',
            'posisi_id' => 'sometimes|exists:posisi_kandidats,id',
            'slogan' => 'sometimes|string',
            'visi_misi' => 'sometimes|file|mimes:pdf,doc,docx',
            'nama_pemilihan_id' => 'sometimes|exists:pemilihans,id',
        ]);

        if ($request->hasFile('visi_misi')) {
            Storage::delete($pemilihanKandidat->visi_misi_path);
            $visiMisiPath = $request->file('visi_misi')->store('visi_misi_files');
            $pemilihanKandidat->visi_misi_path = $visiMisiPath;
        }

        $pemilihanKandidat->update($request->only(['no_urut', 'kandidat_id', 'posisi_id', 'slogan', 'nama_pemilihan_id']));

        return response()->json($pemilihanKandidat);
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $pemilihanKandidat = PemilihanKandidat::findOrFail($id);
        Storage::delete($pemilihanKandidat->visi_misi_path);
        $pemilihanKandidat->delete();

        return response()->json(['message' => 'Pemilihan Kandidat deleted successfully']);
    }
}
