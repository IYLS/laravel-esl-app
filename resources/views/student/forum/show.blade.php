@extends('layouts.app')
@section('title', $comment->title ?? 'Forum')

@section('main')
<div class="forum-page">
    <a href="{{ route('forum.index') }}" class="forum-back-link">
        <span class="material-symbols-outlined" style="font-size:1.2rem;">arrow_back</span>
        Volver al foro
    </a>

    {{-- Post principal --}}
    @php
        $isOwn = $comment->user_id == $current_user->id;
        $authorName = ($comment->user->name ?? '') == $current_user->name ? 'me' : ($comment->user->name ?? '');
    @endphp
    <article class="forum-card forum-detail-card {{ $isOwn ? 'own' : '' }}">
        <div class="forum-post-header">
            <x-forum-avatar :user="$comment->user ?? null" size="lg" />
            <div class="forum-post-body">
                <h1 class="forum-detail-title">{{ $comment->title }}</h1>
                <div class="forum-detail-content">{{ $comment->content }}</div>
                <div class="forum-post-meta">
                    <x-user-mention :name="$authorName" />
                    <span>·</span>
                    <x-forum-time :datetime="$comment->created_at" />
                </div>
            </div>
        </div>
        <div class="forum-post-footer">
            <div class="forum-post-actions">
                <span class="forum-stat">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    {{ $replies_number }} {{ $replies_number == 1 ? 'respuesta' : 'respuestas' }}
                </span>
                <x-reaction-picker type="comment" :id="$comment->id" :reactions="$comment->reactions ?? collect()" />
            </div>
            @if($isOwn || Auth::user()->role == 'teacher')
                <form action="{{ route('forum.destroy', $comment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="forum-btn-delete" onclick="return confirm('¿Eliminar este post?');">
                        <span class="material-symbols-outlined" style="font-size:1rem;">delete</span>
                        Eliminar
                    </button>
                </form>
            @endif
        </div>
    </article>

    {{-- Respuestas --}}
    <section class="forum-replies-section">
        <h2 class="forum-section-title">Respuestas ({{ $replies_number }})</h2>
        <div class="forum-replies-list">
            @forelse($replies as $reply)
                @php
                    $replyAuthorName = ($reply->user->name ?? '') == $current_user->name ? 'me' : ($reply->user->name ?? '');
                @endphp
                <div class="forum-reply-item">
                    <x-forum-avatar :user="$reply->user ?? null" size="sm" />
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="forum-reply-text">{{ $reply->content }}</div>
                        <div class="forum-reply-meta mb-2">
                            <x-user-mention :name="$replyAuthorName" />
                            <span> · </span>
                            <x-forum-time :datetime="$reply->created_at" />
                        </div>
                        <x-reaction-picker type="reply" :id="$reply->id" :reactions="$reply->reactions ?? collect()" />
                    </div>
                </div>
            @empty
                <div class="forum-empty py-4">
                    <p class="text-muted mb-0">Sin respuestas aún. ¡Sé el primero en responder!</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Formulario responder --}}
    <section class="forum-reply-form-section">
        <div class="forum-form-card">
            <h2 class="forum-section-title">Responder</h2>
            <form action="{{ route('replies.store', $comment->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="forum-compose-wrap position-relative">
                        <textarea id="forum-reply-content" name="content" class="form-control" rows="4" placeholder="Escribe tu respuesta..." required></textarea>
                        <div class="forum-compose-actions">
                            <x-emoji-picker target="forum-reply-content" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined" style="font-size:1.1rem; vertical-align:middle;">send</span>
                    Enviar respuesta
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
