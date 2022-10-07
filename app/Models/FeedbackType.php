<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class FeedbackType extends Model
{
    use HasFactory;

    protected $table = 'feedback_types';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'level',
        'text_based'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function existingFeedback() { return $this->hasMany(Feedback::class, 'feedback_type_id'); }
}
