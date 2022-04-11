<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyLevel extends Model
{
    use HasFactory;

    protected $table = 'proficiency_levels';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;


    public function units() {
        return $this->hasMany('App\Models\Unit');
    }
}
