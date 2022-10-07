<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Alternative extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alternatives';
    protected $fillable = [ 
        'title',
        'correct_alt',
    ];

    public $timestamps = false;
    public $incrementing = true;
    
    public function question() { return $this->belongsTo(Question::class); }
    public function feedback() { return $this->hasOne(Feedback::class); }
}