<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Unit;


class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'groups';
    protected $fillable = [
        'name',
        'leaderboard_enabled',
    ];

    protected $casts = [
        'leaderboard_enabled' => 'boolean',
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function units() { return $this->belongsToMany(Unit::class, 'unit_group'); }
    public function users() { return $this->hasMany(User::class); }
}
