<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackType extends Model
{
    use HasFactory;

    protected $table = 'feedback_types';

    protected $fillable = [
        'name',
        'description'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function existingFeedback() { return $this->hasMany(Feedback::class, 'feedback_type_id'); }
}
