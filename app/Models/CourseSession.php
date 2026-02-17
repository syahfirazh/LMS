<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSession extends Model
{
    use HasFactory;

    protected $fillable = [
    'kelas_id',
    'judul',
    'deskripsi',
    'urutan',
    'instruksi',
    'tanggal',
];

protected $casts = [
    'tanggal' => 'date',
];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class, 'session_id');
    }

    public function discussions()
    {
        return $this->hasMany(Diskusi::class, 'session_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'course_session_id');
    }

        
}
