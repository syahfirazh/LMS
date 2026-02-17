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
        'homebase',
        'jabatan',
        'bidang_keahlian',
        'foto',
        'password',
    ];

    protected $casts = [
        'bidang_keahlian' => 'array',
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
