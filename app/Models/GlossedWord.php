<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlossedWord extends Model
{
    use HasFactory;

    protected $table = 'glossed_words';
    protected $fillable = [
        'glossed_word',
        'description',
    ];
    public $timestamps = false;
    public $incrementing = true;
}
