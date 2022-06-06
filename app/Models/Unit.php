<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Keyword;
use App\Models\Group;

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
        'transcript',
        'glossary',
        'translation',
        'dictionary',
    ];

    public $timestamps = false;
    public $incrementing = true;


    public function keywords() 
    {
        return $this->hasMany(Keyword::class);
    }

    public function group() 
    {
        return $this->belongsTo(Group::class);    
    }
}
