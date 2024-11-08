<?php

namespace App\Http\Controllers;

use App\Models\DataPemilih;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DataPemilihController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // CREATE
    public function store(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:data_pemilih',
            'unit_apartement' => 'required|string',
            'nomor_unit_apartement' => 'required|string',
            'email' => 'required|string|email|unique:data_pemilih',
            'no_telephone' => 'required|string',
            'password' => 'required|string|min:8',
            'upload_image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('public/images');
            $validatedData['upload_image'] = $path;
        }

        $validatedData['password'] = Hash::make($request->password);
        $validatedData['role'] = 'user'; // Set default role

        $users = User::create($validatedData);

        return response()->json($users, 201);
    }

    // READ (index)
    public function index(Request $request)
    {
        $this->authorizeAdmin($request->user());
        $users = User::all();
        return response()->json($users);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin($request->user());

        $users = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'nik' => 'sometimes|string|unique:data_pemilih,nik,' . $id,
            'unit_apartement' => 'sometimes|string',
            'nomor_unit_apartement' => 'sometimes|string',
            'email' => 'sometimes|string|email|unique:data_pemilih,email,' . $id,
            'no_telephone' => 'sometimes|string',
            'password' => 'nullable|string|min:8',
            'upload_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('upload_image')) {
            // Delete old image if exists
            if ($users->upload_image) {
                Storage::delete($users->upload_image);
            }
            $path = $request->file('upload_image')->store('public/images');
            $validatedData['upload_image'] = $path;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $users->update($validatedData);

        return response()->json($users);
    }

    // DELETE
    public function destroy(Request $request, $id)
    {
        $this->authorizeAdmin($request->user());

        $users = User::findOrFail($id);

        // Delete image if exists
        if ($users->upload_image) {
            Storage::delete($users->upload_image);
        }

        $users->delete();

        return response()->json(['message' => 'Data Pemilih deleted successfully']);
    }

    private function authorizeAdmin($user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }
}
