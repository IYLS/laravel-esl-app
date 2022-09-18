<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Excercise;
use App\Models\FeedbackType;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'message',
        'audio_url'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(Excercise::class); }
    public function question() { return $this->belongsTo(Question::class); }
    public function type() { return $this->belongsTo(FeedbackType::class); }
}
