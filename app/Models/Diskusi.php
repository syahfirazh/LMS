<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CourseSession;

class Diskusi extends Model
{
    protected $table = 'diskusis';

    protected $fillable = [
    'session_id',
    'sender_id',
    'sender_type',
    'message',
    'image',
    'voice'
];


    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
{
    return $this->morphTo();
}


}
