<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\DragAndDropExcercise;


class DragAndDropQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'drag_and_drop_questions';
    protected $fillable = [ 
        'word',
        'definition'
    ];

    public $timestamps = false;
    public $incrementing = true;


    public function excercise() { return $this->belongsTo(DragAndDropExcercise::class); }
}