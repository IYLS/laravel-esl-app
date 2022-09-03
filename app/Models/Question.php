<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [ 
        'statement',
        'answer',
        'image_name',
        'audio_name',
        'type',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function alternatives() { return $this->hasMany(Alternative::class, 'question_id'); }
    public function excercise() { return $this->belongsTo(Excercise::class); }
}
