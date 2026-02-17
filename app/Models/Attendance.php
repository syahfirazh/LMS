<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'course_session_id',
        'mahasiswa_id',
        'status',
        'waktu_absen',
    ];

    public function courseSession()
    {
        return $this->belongsTo(CourseSession::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
