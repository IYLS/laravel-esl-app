<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excercise extends Model
{
    use HasFactory;

    protected $table = 'excersices';
    protected $fillable = [
        'name',
        'description',
    ];
    public $timestamps = false;
    public $incrementing = true;
}