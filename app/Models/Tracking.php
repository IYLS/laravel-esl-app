<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Models\Unit;

class Tracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracking';
    protected $fillable = [
        'intent_number',
        'time_spent_in_minutes',
        'correct_answers',
        'wrong_ansers',
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function responses() { return $this->hasMany(UserResponse::class); }
    public function exercise() { return $this->belongsTo(Exercise::class); } 
    public function user() { return $this->belongsTo(User::class); }
}