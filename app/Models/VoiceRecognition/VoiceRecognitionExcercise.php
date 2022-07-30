<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceRecognitionExcercise extends ExcerciseType
{
    use HasFactory;

    protected $table = 'voice_recognition_excercises';
    protected $fillable = [
        'title',
        'description',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function questions()
    {
        return $this->hasMany(VoiceRecognitionQuestion::class);
    }
}