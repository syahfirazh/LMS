<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal
    protected $guarded = ['id'];

    // Relasi balik ke tabel Exam (Ujian)
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi ke tabel ExamOption (Pilihan Jawaban A, B, C, D)
    public function options()
    {
        return $this->hasMany(ExamOption::class);
    }
}