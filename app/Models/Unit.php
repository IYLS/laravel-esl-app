<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Keyword;
use App\Models\Group;
use App\Models\Section;
use App\Models\GlossedWord;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'units';
    protected $fillable = [
        'title',
        'author',
        'description',
        'listening_tips',
        'cultural_notes',
        'transcript',
        'glossary',
        'translation',
        'dictionary',
        'listening_tips_enabled',
        'cultural_notes_enabled',
        'transcript_enabled',
        'glossary_enabled',
        'translation_enabled',
        'dictionary_enabled',
        'video_name',
        'video_copyright'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function sections() { return $this->hasMany(Section::class); }
    public function keywords() { return $this->hasMany(Keyword::class); }
    public function glossedWords() { return $this->hasMany(GlossedWord::class); }
    public function groups() { return $this->belongsToMany(Group::class, 'unit_group'); }
}
