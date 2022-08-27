<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackType extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'name',
        'description'
    ];
    public $timestamps = false;
    public $incrementing = true;
}
