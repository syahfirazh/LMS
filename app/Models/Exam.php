<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['dosen_id', 'kelas_id', 'judul', 'kategori', 'waktu_mulai', 'waktu_selesai', 'deskripsi'];
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function kelas() { return $this->belongsTo(Kelas::class); }
}