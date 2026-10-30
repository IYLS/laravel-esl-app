@props(['datetime'])
@php
    $diff = $datetime->diffInSeconds(now());
    if ($diff <= 59) {
        $text = $diff == 0 ? 'just now' : $diff . ' seconds ago';
    } elseif ($datetime->diffInMinutes(now()) <= 59) {
        $text = $datetime->diffInMinutes(now()) . ' minutes ago';
    } elseif ($datetime->diffInHours(now()) <= 23) {
        $text = $datetime->diffInHours(now()) . ' hours ago';
    } elseif ($datetime->diffInDays(now()) >= 1) {
        $days = $datetime->diffInDays(now());
        $text = $days == 1 ? 'yesterday' : $days . ' days ago';
    } else {
        $text = $datetime->format('M d, Y');
    }
@endphp
<time datetime="{{ $datetime->toIso8601String() }}">{{ $text }}</time>
