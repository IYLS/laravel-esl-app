<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcerciseType extends Model
{
    use HasFactory;

    protected $table = 'excetcise_types';

    protected $fillable = [
        'name',
        'description'
    ];
    public $timestamps = false;
    public $incrementing = true;
}