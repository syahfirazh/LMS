<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionMessage extends Model
{
    use HasFactory;

    protected $table = 'submission_messages';

    // Sesuaikan dengan kolom database Anda
    protected $fillable = [
        'submission_id',
        'from', // 'dosen' atau 'mahasiswa'
        'body', // isi pesan teks
        'image',
        'voice',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}