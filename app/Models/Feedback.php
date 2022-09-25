<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Exercise;
use App\Models\FeedbackType;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'message',
        'audio_name'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function exercise() { return $this->belongsTo(Exercise::class); }
    public function question() { return $this->belongsTo(Question::class); }
    public function feedbackType() { return $this->belongsTo(FeedbackType::class); }
}
