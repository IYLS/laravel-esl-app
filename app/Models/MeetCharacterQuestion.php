<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetCharacterQuestion extends Model
{
    use HasFactory;

    protected $table = 'meet_characters_questions';
    protected $fillable = [
        'image_url',
        'audio_url',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function excercise()
    {
        return $this->belongsTo(MeetCharacterExcercise::class);
    }
}
