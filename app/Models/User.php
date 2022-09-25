<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class User extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $hidden = ['password'];
    protected $fillable = [
        'user_id',
        'password',
        'name', 
        'age', 
        'gender', 
        'language', 
        'email', 
        'role', 
        'activated'
    ];
    public $timestamps = false;
    public $incrementing = true;

    public function group() 
    {
        return $this->belongsTo(Group::class);    
    }
}