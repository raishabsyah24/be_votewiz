<?php

namespace App\Http\Controllers;

use App\Models\DataPemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik',
            'unit_apartement' => 'required|string',
            'nomor_unit_apartement' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_telephone' => 'required|string',
            'password' => 'required|string|min:8',
            
            'upload_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Upload image jika ada
        if ($request->hasFile('upload_image')) {
            $validated['upload_image'] = $request->file('upload_image')->store('uploads', 'public');
        }

        // Hash password dan buat user
        $validated['password'] = Hash::make($request->password);
        $validated['role'] = 'user';
        $user = User::create($validated);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    // Fungsi untuk mengupdate data user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'nik' => 'sometimes|string|unique:users,nik,' . $id,
            'unit_apartement' => 'sometimes|string',
            'nomor_unit_apartement' => 'sometimes|string',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'no_telephone' => 'sometimes|string',
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:admin,user',
            'upload_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('upload_image')) {
            $validated['upload_image'] = $request->file('upload_image')->store('uploads', 'public');
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
    }

    // Fungsi untuk menghapus user
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
}
