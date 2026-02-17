<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeWeight extends Model
{
   protected $fillable = ['kelas_id', 'absen', 'tugas', 'uts', 'uas'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
