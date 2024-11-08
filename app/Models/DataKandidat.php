<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKandidat extends Model
{
    use HasFactory;



    protected $fillable = [
        'nama_kandidat', 'nik', 'umur_kandidat', 'tempat_lahir', 'tanggal_lahir', 'latar_belakang', 'pencapaian', 'foto_profile'
    ];
}
