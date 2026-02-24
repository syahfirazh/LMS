<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id',
        'mahasiswa_id',
        'file_path',
        'text_submission', // Atau text_online (sesuaikan DB Anda)
        'voice_submission', // Atau voice_url (sesuaikan DB Anda)
        'nilai',
        'feedback'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // WAJIB ADA UNTUK CHAT
    public function messages()
    {
        return $this->hasMany(SubmissionMessage::class, 'submission_id');
    }
}