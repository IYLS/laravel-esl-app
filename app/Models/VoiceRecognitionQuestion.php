<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VoiceRecognitionExcercise;

class VoiceRecognitionQuestion extends Model
{
    use HasFactory;

    protected $table = 'voice_recognition_questions';
    protected $fillable = [
        'image_url',
        'audio_url',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(VoiceRecognitionExcercise::class); }
}
