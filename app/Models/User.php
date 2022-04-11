<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Model
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
        'activated',
        'group'
    ];
    public $timestamps = false;
    public $incrementing = true;
}