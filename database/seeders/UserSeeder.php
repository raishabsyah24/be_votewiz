<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'nik' => '1234567890123456',
            'unit_apartement' => 'A1',
            'nomor_unit_apartement' => '101',
            'email' => 'admin@mail.com',
            'no_telephone' => '081234567890',
            'password' => Hash::make('12345678'), // Gunakan Hash untuk keamanan
            'role' => 'admin',
            'token' => Str::random(60),
            'upload_image' => null, // Set null atau path gambar jika ada
        ]);
    }
}
