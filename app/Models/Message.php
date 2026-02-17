<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'submission_id',
        'from',
        'body',
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'image_path',
        'is_read'
    ];
}
