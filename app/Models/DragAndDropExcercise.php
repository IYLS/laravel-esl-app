<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DragAndDropQuestion;
use App\Models\Section;

class DragAndDropExcercise extends Model
{
    use HasFactory;

    protected $table = 'drag_and_drop_excercises';
    protected $fillable = [ 
        'title',
        'description',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions() { return $this->hasMany(DragAndDropQuestion::class, 'excercise_id'); }
    public function section() { return $this->belongsTo(Section::class); }
}