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
        'title',
        'image_url',
        'image_name',
        'audio_url',
        'audio_name',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(VoiceRecognitionExcercise::class); }
}
