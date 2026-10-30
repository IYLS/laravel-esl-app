<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Models\Unit;

class Tracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracking';
    protected $fillable = [
        'intent_number',
        'time_spent_in_seconds',
        'correct_answers',
        'wrong_ansers'
    ];

    public $timestamps = true;
    public $incrementing = true;

    public function userResponses() { return $this->hasMany(UserResponse::class); }
    public function exercise() { return $this->belongsTo(Exercise::class); } 
    public function user() { return $this->belongsTo(User::class); }
    public function helpUsage() { return $this->hasMany(TrackingHelpUsage::class); }
    public function feedbackUsage() { return $this->hasMany(TrackingFeedbackUsage::class); }

    /**
     * Formatea el tiempo en segundos a formato legible (04h 30m 23s)
     * Solo muestra las unidades que existen
     */
    public function getFormattedTimeAttribute()
    {
        $seconds = (int)$this->time_spent_in_seconds;
        
        if ($seconds === 0) {
            return '0s';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        $parts = [];
        if ($hours > 0) {
            $parts[] = sprintf('%02dh', $hours);
        }
        if ($minutes > 0) {
            $parts[] = sprintf('%02dm', $minutes);
        }
        if ($secs > 0 || count($parts) === 0) {
            $parts[] = sprintf('%02ds', $secs);
        }

        return implode(' ', $parts);
    }
}