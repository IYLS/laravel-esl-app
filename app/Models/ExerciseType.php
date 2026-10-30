<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Exercise;

class ExerciseType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exercise_types';

    protected $fillable = [
        'name',
        'underscore_name',
        'description'
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function exercises() { return $this->hasMany(Exercise::class, 'exercise_type_id'); }
}