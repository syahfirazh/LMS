<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'kelas_id',
        'mahasiswa_id',
        'tugas',
        'uts',
        'uas',
        'absen',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

