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
    'pertemuan_ke'
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

    public function getIsActiveAttribute()
{
    if ($this->is_done) {
        return false;
    }

    $previous = self::where('kelas_id', $this->kelas_id)
        ->where('urutan', '<', $this->urutan)
        ->whereDoesntHave('materis')
        ->exists();

    return !$previous;
}

public function isCompleted()
{
    return $this->materis()->exists();
}

    public function discussions()
    {
        return $this->hasMany(Diskusi::class, 'session_id');
    }

   public function attendances()
{
    return $this->hasMany(Attendance::class);
}

        public function messages()
{
    return $this->hasMany(SessionMessage::class, 'session_id');
}
}
