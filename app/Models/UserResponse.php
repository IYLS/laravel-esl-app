<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tracking;
use App\Models\Question;

class UserResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_responses';

    protected $fillable = [
        'response',
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function question() { return $this->belongsTo(Question::class); }
    public function tracking() { return $this->belongsTo(Tracking::class); } 
}