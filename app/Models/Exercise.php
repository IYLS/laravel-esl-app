<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Question;
use App\Models\ExerciseType;
use App\Models\Feedback;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exercises';

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'subtype',
        'image_name',
        'video_name',
        'extra_info',
        'position'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(Question::class, 'exercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
    public function exerciseType() { return $this->belongsTo(ExerciseType::class); }
    public function feedbacks() { return $this->hasMany(Feedback::class, 'exercise_id'); }
    public function tracking() { return $this->hasOne(Tracking::class); }
}
