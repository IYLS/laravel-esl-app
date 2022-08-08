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
        'type'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(OpenEndedQuestion::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}
