<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Tambahkan user_id dan user_type agar diizinkan masuk oleh Laravel
    protected $fillable = [
        'user_id',       // <-- Baru
        'user_type',     // <-- Baru
        'mahasiswa_id',
        'type',
        'title',
        'message',
        'url',
        'is_read'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}