@props(['class' => '', 'label' => null])

@php
    $buttonText = ($label !== null && trim((string) $label) !== '') ? trim((string) $label) : 'Go to Forum';
@endphp

<a href="{{ route('forum.index') }}" class="btn btn-outline-primary {{ $class }}" style="display: inline-flex; align-items: center; gap: 0.5rem;">
    <span class="material-symbols-outlined">forum</span>
    <span>{{ $buttonText }}</span>
</a>
