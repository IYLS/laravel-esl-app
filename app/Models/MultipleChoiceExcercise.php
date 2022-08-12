<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MultipleChoiceQuestion;
use App\Models\Section;

class MultipleChoiceExcercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'multiple_choice_excercises';
    protected $fillable = [ 
        'title',
        'description',
        'instructions',
        'type',
        'subtype',
        'image_name',
        'video_name'
    ];

    public $timestamps = false;
    public $incrementing = true;
    
    public function questions() { return $this->hasMany(MultipleChoiceQuestion::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}