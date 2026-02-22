<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionMessage extends Model
{
    use HasFactory;

    protected $table = 'submission_messages';

    protected $fillable = [
        'submission_id',
        'from',
        'body',
        'image',
        'voice',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}