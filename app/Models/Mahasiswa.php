<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    protected $table = 'mahasiswas';

    protected $fillable = ['nim', 'nama', 'password'];

    protected $hidden = ['password'];

  public function kelas()
{
    return $this->belongsToMany(
        Kelas::class,
        'kelas_mahasiswa'
    )->withPivot(['absen','tugas','uts','uas']);
}



    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function grade()
{   
    return $this->hasOne(Grade::class);
}



}
