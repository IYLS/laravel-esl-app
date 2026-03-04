@props(['target' => 'content'])
@php
    $emojis = ['😀','😊','😂','😍','👍','👏','❤️','🔥','🎉','😢','😮','😎','🤔','🙌','✨','💬','⭐','💪','👋','🎯','💡','✅','❌','😅','🥳'];
@endphp
<div class="emoji-picker-wrapper" data-target="{{ $target }}" data-align="end">
    <button type="button" class="btn btn-sm btn-light emoji-trigger border" title="Insert emoji" aria-label="Insert emoji">
        <span class="material-symbols-outlined">emoji_emotions</span>
    </button>
    <div class="emoji-picker-dropdown forum-picker-popover bg-white border rounded-3 shadow p-2" role="dialog" aria-label="Insert emoji" aria-hidden="true">
        <div class="emoji-picker-label text-muted small mb-1 px-1">Insert emoji</div>
        <div class="emoji-grid">
            @foreach($emojis as $e)
                <button type="button" class="emoji-btn" data-emoji="{{ $e }}" title="{{ $e }}">{{ $e }}</button>
            @endforeach
        </div>
    </div>
</div>
