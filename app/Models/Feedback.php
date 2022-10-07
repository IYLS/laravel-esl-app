<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Question;
use App\Models\Exercise;
use App\Models\FeedbackType;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedback';

    protected $fillable = [
        'message',
        'audio_name'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function alternative() { return $this->belongsTo(Alternative::class); }
    public function exercise() { return $this->belongsTo(Exercise::class); }
    public function question() { return $this->belongsTo(Question::class); }
    public function feedbackType() { return $this->belongsTo(FeedbackType::class); }
}
