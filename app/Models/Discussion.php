<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    // Pastikan nama tabel sesuai dengan migration kamu
    protected $table = 'diskusis';
    
    protected $fillable = [
        'session_id',
        'sender_id',
        'sender_type', // WAJIB ADA: Untuk membedakan Dosen atau Mahasiswa
        'message',
        'image',
        'voice',
    ];

    /**
     * Relasi Pengirim Pesan (Polimorfik)
     * Otomatis mencari ke tabel 'dosens' atau 'mahasiswas' berdasarkan 'sender_type'
     */
    public function sender()
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke Sesi / Pertemuan Kelas
     */
    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'session_id');
    }
}