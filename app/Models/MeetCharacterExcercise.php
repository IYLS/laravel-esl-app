<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetCharacterExcercise extends Model
{
    use HasFactory;

    protected $table = 'meet_characters_excercises';
    protected $fillable = [
        'title',
        'description',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function questions()
    {
        return $this->hasMany(MeetCharacterQuestion::class);
    }
}
