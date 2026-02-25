<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosenNotification extends Model
{
    protected $table = 'dosen_notifications';

    protected $fillable = [
        'dosen_id',
        'type',
        'title',
        'message',
        'url',
        'is_read',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}