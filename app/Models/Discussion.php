<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'diskusis';
    
    protected $fillable = [
    'session_id',
    'sender_id',
    'message',
    'image',
    'voice',
    
];

    public function sender()
{
    return $this->belongsTo(User::class, 'sender_id');
}

}
