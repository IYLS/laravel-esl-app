<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'replies';
    protected $fillable = [ 
        'content',
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function comment() { return $this->belongsTo(Comment::class); }
    public function user() { return $this->belongsTo(User::class); }
}
