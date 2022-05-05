<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreListening extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $fillable = [
        'title',
        'author',
        'description',
        'listening_tips',
        'cultural_notes',
        'technology_notes',
        'biology_notes',
        'transcript',
        'glossary',
        'translation',
        'dictionary',
        'video_url'
    ];

    public $timestamps = false;
    public $incrementing = true;
}
