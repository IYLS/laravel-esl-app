<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Exercise;
use App\Models\Unit;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sections';
    protected $fillable = [
        'name',
        'underscore_name',
        'instructions'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function exercises() { return $this->hasMany(Exercise::class); }
    public function unit() { return $this->belongsTo(Unit::class); }
}
