<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Feedback;

class FeedbackType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedback_types';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'level',
        'text_based'
    ];
    public $timestamps = true;
    public $incrementing = true;

    public function existingFeedback() { return $this->hasMany(Feedback::class, 'feedback_type_id'); }
}
