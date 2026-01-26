@props(['class' => ''])

<a href="{{ route('forum.index') }}" class="btn btn-outline-primary {{ $class }}" style="display: inline-flex; align-items: center; gap: 0.5rem;">
    <span class="material-symbols-outlined">forum</span>
    <span>Go to Forum</span>
</a>
