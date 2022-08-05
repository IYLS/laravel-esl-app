<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OpenEndedExcercise;


class OpenEndedQuestion extends Model
{
    use HasFactory;

    public function excercise() { return $this->belongsTo(OpenEndedExcercise::class); }
}
