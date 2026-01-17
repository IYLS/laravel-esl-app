<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingFeedbackUsage extends Model
{
    use HasFactory;

    protected $table = 'tracking_feedback_usage';

    protected $fillable = [
        'tracking_id',
        'feedback_type',
        'open_count'
    ];

    public $timestamps = true;

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }
}
