<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
    'judul',
    'pertemuan',
    'instruksi',
    'kelas_id'
];
public function materis()
{
    return $this->hasMany(Materi::class, 'session_id');
}

}
