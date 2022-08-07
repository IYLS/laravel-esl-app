<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OpenEndedExcercise;


class OpenEndedQuestion extends Model
{
    use HasFactory;

    protected $table = 'open_ended_questions';
    protected $fillable = [ 
        'title',
        'answer',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(OpenEndedExcercise::class); }
}
