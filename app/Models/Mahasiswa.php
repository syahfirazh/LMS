<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Kelas;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Submission;
use App\Models\MataKuliah;
use App\Models\User;

class Mahasiswa extends Authenticatable
{
    protected $table = 'mahasiswas';

    protected $fillable = ['nim', 'nama', 'password', 'prodi',
    'fakultas',
    'semester',
    'tahun_masuk',
    'status',
    'email_kampus',
    'email_pribadi',
    'no_hp',
    'foto',];

    protected $hidden = ['password'];

  public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class,
            'kelas_mahasiswa',
            'mahasiswa_id',
            'kelas_id'
        )->withPivot(['absen', 'tugas', 'uts', 'uas']);
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'kelas_mahasiswa');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function attendances()
{
    return $this->hasMany(Attendance::class);
}

}
