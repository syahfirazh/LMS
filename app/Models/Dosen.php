<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Dosen extends Authenticatable
{
    use Notifiable;

    protected $table = 'dosens';

    protected $fillable = [
        'nama',
        'nidn',
        'email',
        'no_hp',
        'homebase',
        'jabatan',
        'foto',
        'password',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'dosen_id');
    }
}