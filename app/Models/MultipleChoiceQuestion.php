<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\MultipleChoiceExcercise;
use App\Models\MultipleChoiceAlternative;

class MultipleChoiceQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'multiple_choice_questions';
    protected $fillable = [ 
        'statement',
        'audio_name'
    ];

    public $timestamps = false;
    public $incrementing = true;
    
    public function alternatives() { return $this->hasMany(MultipleChoiceAlternative::class, 'question_id'); }
    public function excercise() { return $this->belongsTo(MultipleChoiceExcercise::class); }
}
