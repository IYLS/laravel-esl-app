@props(['name', 'url' => null])

@php
    $displayName = $name ? '@' . $name : '@unknown';
@endphp

@if($url)
    <a href="{{ $url }}" class="user-mention-link">
        {{ $displayName }}
    </a>
@else
    <span class="user-mention">
        {{ $displayName }}
    </span>
@endif
