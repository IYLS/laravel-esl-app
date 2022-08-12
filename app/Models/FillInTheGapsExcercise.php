<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\FillInTheGapsQuestion;
use App\Models\Section;

class FillInTheGapsExcercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fill_in_the_gaps_excercises';
    protected $fillable = [ 
        'title',
        'description',
        'type',
        'subtype'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(FillInTheGapsQuestion::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}
