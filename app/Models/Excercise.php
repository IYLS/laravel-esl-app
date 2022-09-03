<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Question;

class Excercise extends Model
{
    use HasFactory;

    protected $table = 'excercises';

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'type',
        'subtype',
        'image_name',
        'video_name'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(Question::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}
