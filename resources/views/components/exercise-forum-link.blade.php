@props(['exercise'])

@if($exercise->show_forum_link)
    <div class="mt-3 mb-3">
        <x-forum-link class="btn-sm" :label="$exercise->forum_button_label" />
    </div>
@endif
