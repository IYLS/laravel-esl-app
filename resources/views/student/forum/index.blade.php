@extends('layouts.app')
@section('title', 'Forum')

@section('main')
<div class="forum-page">
    <h1 class="forum-page-title">
        <span class="material-symbols-outlined">forum</span>
        Forum
    </h1>

    {{-- Lista de posts --}}
    <section class="forum-posts-section">
        @if(isset($comments) && $comments->count() > 0)
            @foreach($comments as $comment)
                @php
                    $isOwn = $comment->user_id == $current_user->id;
                    $authorName = ($comment->user->name ?? '') == $current_user->name ? 'me' : ($comment->user->name ?? '');
                @endphp
                <article class="forum-card {{ $isOwn ? 'own' : '' }}">
                    <a href="{{ route('forum.show', $comment->id) }}" class="forum-post-link">
                        <div class="forum-post-header">
                            <x-forum-avatar :user="$comment->user ?? null" size="md" />
                            <div class="forum-post-body">
                                <h2 class="forum-post-title">{{ $comment->title }}</h2>
                                <p class="forum-post-preview">{{ Str::limit(strip_tags($comment->content), 120) }}</p>
                                <div class="forum-post-meta">
                                    <x-user-mention :name="$authorName" />
                                    <span>·</span>
                                    <x-forum-time :datetime="$comment->created_at" />
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="forum-post-footer">
                        <div class="forum-post-actions">
                            <a href="{{ route('forum.show', $comment->id) }}" class="forum-stat">
                                <span class="material-symbols-outlined">chat_bubble</span>
                                {{ $comment->replies->count() }}
                            </a>
                            <div onclick="event.preventDefault(); event.stopPropagation();">
                                <x-reaction-picker type="comment" :id="$comment->id" :reactions="$comment->reactions ?? collect()" />
                            </div>
                        </div>
                        @if($isOwn || Auth::user()->role == 'teacher')
                            <form action="{{ route('forum.destroy', $comment->id) }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
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
            @endforeach
        @else
            <div class="forum-empty">
                <div class="forum-empty-icon">
                    <span class="material-symbols-outlined">forum</span>
                </div>
                <p class="mb-0">No hay posts aún. ¡Sé el primero en escribir!</p>
            </div>
        @endif
    </section>

    {{-- Formulario nuevo post --}}
    <section class="forum-new-post-section mt-4">
        <div class="forum-form-card">
            <h2 class="forum-section-title">Nuevo post</h2>
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="forum-title" class="form-label">Título</label>
                    <input type="text" id="forum-title" name="title" class="form-control" placeholder="Título del post" required>
                </div>
                <div class="mb-3">
                    <label for="forum-content" class="form-label">Contenido</label>
                    <div class="forum-compose-wrap position-relative">
                        <textarea id="forum-content" name="content" class="form-control" rows="4" placeholder="Escribe tu mensaje..." required></textarea>
                        <div class="forum-compose-actions">
                            <x-emoji-picker target="forum-content" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined" style="font-size:1.1rem; vertical-align:middle;">send</span>
                    Publicar
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
