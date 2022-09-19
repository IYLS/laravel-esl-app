<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';
    protected $fillable = [ 
        'statement',
        'answer',
        'image_name',
        'audio_name',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function feedback() { return $this->hasOne(Feedback::class); }
    public function alternatives() { return $this->hasMany(Alternative::class, 'question_id'); }
    public function exercise() { return $this->belongsTo(Exercise::class); }
}
