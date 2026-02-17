<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'session_id',
        'judul',
        'type',
        'file',
        'link'
    ];

    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'session_id');
    }
}
