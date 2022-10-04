<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\Alternative;
use App\Models\Exercise;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';
    protected $fillable = [ 
        'statement',
        'answer',
        'image_name',
        'audio_name',
        'correct_answer',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function feedbacks() { return $this->hasMany(Feedback::class, 'question_id'); }
    public function alternatives() { return $this->hasMany(Alternative::class, 'question_id'); }
    public function exercise() { return $this->belongsTo(Exercise::class); }
}