<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MultipleChoiceExcercise;

class MultipleChoiceQuestion extends Model
{
    use HasFactory;
    
    public function excercise() { return $this->belongsTo(MultipleChoiceExcercise::class); }
}
