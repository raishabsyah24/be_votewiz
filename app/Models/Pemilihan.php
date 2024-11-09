<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemilihan',
        'tanggal_pemilihan',
        'waktu_mulai',
        'waktu_selesai',
    ];
}
