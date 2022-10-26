<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GlossedWord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'glossed_words';
    protected $fillable = [
        'word',
        'description',
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function unit() { return $this->belongsTo(Unit::class); }
}