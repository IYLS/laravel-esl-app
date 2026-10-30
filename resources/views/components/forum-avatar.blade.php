@props(['user', 'size' => 'md'])
@php
    $sizes = ['sm' => 32, 'md' => 40, 'lg' => 48];
    $px = $sizes[$size] ?? 40;
@endphp
@if($user && $user->avatar)
    <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
         alt="{{ $user->name }}"
         class="forum-avatar"
         style="width: {{ $px }}px; height: {{ $px }}px;"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    <div class="forum-avatar-placeholder" style="display: none; width: {{ $px }}px; height: {{ $px }}px;">
        {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
    </div>
@elseif($user)
    <div class="forum-avatar-placeholder" style="width: {{ $px }}px; height: {{ $px }}px;">
        {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
    </div>
@else
    <div class="forum-avatar-placeholder" style="width: {{ $px }}px; height: {{ $px }}px;">?</div>
@endif
