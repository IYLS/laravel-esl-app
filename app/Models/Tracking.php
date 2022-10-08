<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exercise;
use App\Models\Unit;

class Tracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracking';

    protected $fillable = [
        'intent_number',
        'response',
        'time_spent',
        'correct_answers',
        'wrong_ansers',
        'date',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function exercise() { return $this->hasOne(Exercise::class); }
    public function user() { return $this->hasOne(User::class); }
}
