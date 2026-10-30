<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingHelpUsage extends Model
{
    use HasFactory;

    protected $table = 'tracking_help_usage';

    protected $fillable = [
        'tracking_id',
        'help_type',
        'open_count',
        'time_spent_seconds'
    ];

    public $timestamps = true;

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }

    /**
     * Formatea el tiempo en segundos a formato legible (04h 30m 23s)
     * Solo muestra las unidades que existen
     */
    public function getFormattedTimeAttribute()
    {
        $seconds = (int)$this->time_spent_seconds;
        
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
