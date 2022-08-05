<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OpenEndedQuestion;
use App\Models\Section;

class OpenEndedExcercise extends Model
{
    use HasFactory;

    protected $table = 'open_ended_excercises';
    protected $fillable = [ 
        'title',
        'description',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { $this->hasMany(OpenEndedQuestion::class); }
    public function section() { $this->belongsTo(Section::class); }
}
