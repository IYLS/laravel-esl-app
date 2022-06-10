<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetCharactersQuestion extends Model
{
    use HasFactory;

    protected $table = 'meet_characters_question';
    protected $fillable = [
        'text',
        'position',
        'image_url',
        'audio_url',
    ];

    public $timestamps = false;
    public $incrementing = true;
}