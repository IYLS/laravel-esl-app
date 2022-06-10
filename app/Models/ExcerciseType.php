<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcerciseType extends Model
{
    use HasFactory;

    protected $table = 'excercise_type';
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function units() 
    {
        return $this->hasMany(Unit::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
