<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class ProficiencyLevel extends Model
{
    use HasFactory;

    protected $table = 'proficiency_levels';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
    public $incrementing = true;


    public function units() {
        return $this->hasMany(Unit::class);
    }
}
