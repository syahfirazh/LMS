<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        

    'sender_type', 
    'sender_id', 
    'receiver_type', 
    'receiver_id', 
    'body', 
    'image_path', 
    'voice_path', // WAJIB ADA DISINI
    'is_read'
    ];
}