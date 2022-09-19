<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Excercise;

use App\Models\Unit;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = [
        'name',
        'underscore_name'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function excercises() { return $this->hasMany(Excercise::class); }
    public function unit() { return $this->belongsTo(Unit::class); }
}
