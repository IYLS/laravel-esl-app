<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DragAndDropQuestion;

class DragAndDropExcercise extends Model
{
    use HasFactory;

    protected $table = 'drag_and_drop_excercises';
    protected $fillable = [ 
        'title',
        'description',
        'section'
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function questions()
    {
        return $this->hasMany(DragAndDropQuestion::class);
    }
}