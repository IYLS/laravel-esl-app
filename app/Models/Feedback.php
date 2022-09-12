<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'name',
        'message',
        'audio_url'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function excercise() { return $this->belongsTo(Excercise::class); }
    public function type() { return $this->belongsTo(FeedbackType::class); }
}
