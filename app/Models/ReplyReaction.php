<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyReaction extends Model
{
    use HasFactory;
    
    protected $table = 'reply_reactions';
    protected $fillable = ['reply_id', 'user_id', 'emoji'];

    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
