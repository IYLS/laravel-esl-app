<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GlossedWord;
use App\Models\Keyword;
use App\Models\ProficiencyLevel;

class Unit extends Model
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


    public function keywords() 
    {
        return $this->hasMany(Keyword::class);
    }

    public function glossedWords() 
    {
        return $this->hasMany(GlossedWord::class);
    }

    public function level() {
        return $this->belongsTo(ProficiencyLevel::class);
    }
}
