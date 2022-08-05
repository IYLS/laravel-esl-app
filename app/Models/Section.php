<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VoiceRecognitionExcercise;
use App\Models\MultipleChoiceExcercise;
use App\Models\FillInTheGapsExcercise;
use App\Models\DragAndDropExcercise;
use App\Models\OpenEndedExcercise;
use App\Models\Unit;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function voiceRecognitionExcercises() { return $this->hasMany(VoiceRecognitionExcercise::class); }
    public function multipleChoiceExcercises() { return $this->hasMany(MultipleChoiceExcercise::class); }
    public function fillInTheGapsExcercises() { return $this->hasMany(FillInTheGapsExcercise::class); }
    public function dragAndDropExcercises() { return $this->hasMany(DragAndDropExcercise::class); }
    public function openEndedExcercises() { return $this->hasMany(OpenEndedExcercise::class); }
    public function unit() { return $this->belongsTo(Unit::class); }
}
