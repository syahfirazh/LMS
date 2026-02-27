<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamOption extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal
    protected $guarded = ['id'];

    // Memastikan nilai is_correct selalu dibaca sebagai true/false (boolean)
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relasi balik ke tabel ExamQuestion (Soal)
    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
    }
}