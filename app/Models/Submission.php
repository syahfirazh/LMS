<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
     protected $fillable = [
        'assignment_id',
        'mahasiswa_id',
        'file_path',
        'nilai',
        'feedback',
        'submitted_at'
    ];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function messages()
{
    return $this->hasMany(Message::class);
}


}
