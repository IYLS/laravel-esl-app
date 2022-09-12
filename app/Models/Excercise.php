<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Question;
use App\Models\ExcerciseType;

class Excercise extends Model
{
    use HasFactory;

    protected $table = 'excercises';

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'subtype',
        'image_name',
        'video_name'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(Question::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
    public function excerciseType() { return $this->belongsTo(ExcerciseType::class); }
}
