<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MultipleChoiceQuestion;
use App\Models\Section;

class MultipleChoiceExcercise extends Model
{
    use HasFactory;

    protected $table = 'multiple_choice_excercise';
    protected $fillable = [ 
        'title',
        'description',
    ];

    public $timestamps = false;
    public $incrementing = true;
    
    public function questions() { return $this->hasMany(MultipleChoiceQuestion::class); }
    public function section() { return $this->belongsTo(Section::class); }
}
