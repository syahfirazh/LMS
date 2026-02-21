<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'mata_kuliah_id',
        'kode_kelas',
        'kode_akses',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'sampul', // <--- TAMBAHKAN INI
    ];

    public function mataKuliah()
{
    return $this->belongsTo(MataKuliah::class);
}

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function courseSessions()
    {
        return $this->hasMany(CourseSession::class)->orderBy('urutan');
    }
    
    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'kelas_mahasiswa'
        )->withPivot(['absen','tugas','uts','uas']);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function gradeWeight()
    {
        return $this->hasOne(GradeWeight::class, 'kelas_id');
    }
}