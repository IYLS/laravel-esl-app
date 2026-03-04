@props(['type' => 'comment', 'id' => 0, 'reactions' => collect()])
@php
    $route = $type === 'comment' ? route('reactions.comment', $id) : route('reactions.reply', $id);
    $emojis = ['👍','❤️','😂','😮','😢','🔥','👏','🎉'];
    $grouped = $reactions->groupBy('emoji');
    $containerId = 'reactions-' . $type . '-' . $id;
@endphp
<div class="reaction-picker-wrapper" id="{{ $containerId }}" data-route="{{ $route }}" data-type="{{ $type }}">
    <div class="reactions-list">
        @foreach($grouped as $emoji => $group)
            @php $count = $group->count(); $userReacted = $group->contains('user_id', Auth::id()); @endphp
            <button type="button" class="reaction-btn {{ $userReacted ? 'reacted' : '' }}" data-emoji="{{ $emoji }}" title="{{ $group->pluck('user.name')->implode(', ') }}">
                <span class="reaction-emoji">{{ $emoji }}</span>
                @if($count > 1)<span class="reaction-count">{{ $count }}</span>@endif
            </button>
        @endforeach
    </div>
    <div class="reaction-add-container">
        <button type="button" class="reaction-add-btn" title="Add reaction" aria-haspopup="true">
            <span class="material-symbols-outlined">add_reaction</span>
        </button>
        <div class="reaction-dropdown forum-picker-popover" role="menu" aria-hidden="true">
            <div class="reaction-dropdown-inner">
                @foreach($emojis as $e)
                    <button type="button" class="reaction-emoji-add" data-emoji="{{ $e }}" role="menuitem">{{ $e }}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>
