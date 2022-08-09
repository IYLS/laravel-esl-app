<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FillInTheGapsExcercise;

class FillInTheGapsQuestion extends Model
{
    use HasFactory;

    protected $table = 'fill_in_the_gaps_questions';
    protected $fillable = [ 
        'title',
        'statement',
        'matching_word',
        'audio_name',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(FillInTheGapsExcercise::class); }
}
