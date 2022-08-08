<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MultipleChoiceQuestion;

class MultipleChoiceAlternative extends Model
{
    use HasFactory;

    protected $table = 'multiple_choice_alternatives';
    protected $fillable = [ 
        'title',
        'correct_alt',
    ];

    public $timestamps = false;
    public $incrementing = true;
    
    public function question() { return $this->belongsTo(MultipleChoiceQuestion::class); }
}