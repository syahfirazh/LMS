<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'dosen_id',
        'deskripsi',
        'sampul',
    ];
    
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
