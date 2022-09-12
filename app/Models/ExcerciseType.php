<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Excercise;

class ExcerciseType extends Model
{
    use HasFactory;

    protected $table = 'excercise_types';

    protected $fillable = [
        'name',
        'underscore_name',
        'description'
    ];

    public $incrementing = true;

    public function excercises() { return $this->hasMany(Excercise::class, 'excercise_type_id'); }
}