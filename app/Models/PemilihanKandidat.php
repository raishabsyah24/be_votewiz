<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilihanKandidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_urut',
        'other_field1',
        'other_field2',
        // Add other fields as needed
    ];

    public function kandidat()
    {
        return $this->belongsTo(DataKandidat::class, 'kandidat_id');
    }

    public function posisi()
    {
        return $this->belongsTo(PosisiKandidat::class, 'posisi_id');
    }

    public function nama_pemilihan()
    {
        return $this->belongsTo(Pemilihan::class, 'nama_pemilihan_id');
    }
}
