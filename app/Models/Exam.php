<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    // Kolom apa saja yang boleh diisi
    protected $fillable = [
        'dosen_id', 
        'kelas_id', 
        'judul', 
        'kategori', 
        'waktu_mulai', 
        'waktu_selesai', 
        'deskripsi', 
        'token', 
        'status'
    ];

    // Format tanggal otomatis
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi ke tabel Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke tabel ExamQuestion (Soal Ujian)
    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
    // Relasi ke tabel ExamResult (Hasil pengerjaan mahasiswa)
    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}