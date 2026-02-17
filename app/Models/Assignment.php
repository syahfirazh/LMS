<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
    'kelas_id',
    'judul',
    'deskripsi',
    'deadline',
    'poin',
    'tipe_pengumpulan',
    'file_path',
    'status'
];

public function submissions()
{
    return $this->hasMany(Submission::class);
}

 public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

}
