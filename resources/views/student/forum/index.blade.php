@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    .forum-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .forum-header {
        text-align: center;
        margin-bottom: 1.5rem;
        padding: 1rem 0;
    }
    .forum-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0;
    }
    .forum-posts {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        max-height: 60vh;
        overflow-y: auto;
    }
    .forum-post {
        background: white;
        border: 1px solid var(--color-border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }
    .forum-post:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .forum-post-link {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        text-decoration: none;
    }
    .post-actions {
        position: relative;
        z-index: 2;
    }
    .forum-post.own-post {
        background: var(--color-info-soft);
        border-color: var(--color-info);
    }
    .post-header {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .post-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .post-info {
        flex: 1;
        min-width: 0;
    }
    .post-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        word-wrap: break-word;
    }
    .post-content {
        color: var(--color-text-primary);
        margin-bottom: 0.75rem;
        line-height: 1.6;
        word-wrap: break-word;
    }
    .post-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
        font-size: 0.875rem;
        color: var(--color-text-secondary);
    }
    .post-author {
        font-weight: 500;
    }
    .post-time {
        color: var(--color-text-muted);
    }
    .post-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-left: auto;
        position: relative;
        z-index: 2;
    }
    .post-replies-count {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--color-text-secondary);
        font-size: 0.875rem;
    }
    .post-action-btn {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--color-error);
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        cursor: pointer;
    }
    .post-action-btn.delete-btn:hover {
        background: var(--color-error-soft);
        color: var(--color-error);
    }
    .post-link-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        text-decoration: none;
        cursor: pointer;
    }
    .new-post-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .new-post-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        font-weight: 500;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid var(--color-border);
        padding: 0.75rem;
        font-size: 0.95rem;
    }
    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    .submit-btn {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--color-text-secondary);
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    @media (min-width: 768px) {
        .forum-container {
            padding: 0;
        }
        .forum-header h1 {
            font-size: 2rem;
        }
        .forum-posts {
            padding: 1.5rem;
        }
        .post-header {
            gap: 1rem;
        }
        .post-avatar, .avatar-placeholder {
            width: 48px;
            height: 48px;
            min-width: 48px;
        }
        .post-title {
            font-size: 1.25rem;
        }
        .submit-btn {
            width: auto;
            min-width: 120px;
        }
    }
</style>

<div class="container mt-2 mb-5">
    <div class="forum-container">
        <div class="forum-header">
            <h1>💬 Forum</h1>
        </div>

        <div class="forum-posts">
            @if(isset($comments) && $comments != null && $comments->count() > 0)
                @foreach($comments as $comment)
                    @php
                        $isOwnPost = $comment->user_id == $current_user->id;
                        $authorName = "";
                        if(isset($comment->user->name) && $comment->user->name == $current_user->name) {
                            $authorName = "me";
                        } elseif(isset($comment->user->name)) {
                            $authorName = $comment->user->name;
                        }

                        if ($comment->created_at->diffInSeconds(Carbon::now()) <= 59) {
                            $posted_on = $comment->created_at->diffInSeconds(Carbon::now()) == 0 
                                ? "just now" 
                                : $comment->created_at->diffInSeconds(Carbon::now()) . " seconds ago";
                        } elseif ($comment->created_at->diffInMinutes(Carbon::now()) <= 59) {
                            $posted_on = $comment->created_at->diffInMinutes(Carbon::now()) . " minutes ago";
                        } elseif ($comment->created_at->diffInHours(Carbon::now()) <= 23) {
                            $posted_on = $comment->created_at->diffInHours(Carbon::now()) . " hours ago";
                        } elseif ($comment->created_at->diffInDays(Carbon::now()) >= 1) {
                            $posted_on = $comment->created_at->diffInDays(Carbon::now()) == 1 
                                ? "yesterday" 
                                : $comment->created_at->diffInDays(Carbon::now()) . " days ago";
                        } else {
                            $posted_on = $comment->created_at->format('M d, Y');
                        }
                    @endphp
                    <div class="forum-post {{ $isOwnPost ? 'own-post' : '' }}">
                        <a href="{{ route('forum.show', $comment->id) }}" class="post-link-overlay"></a>
                        <div class="post-header">
                            @if($comment->user && $comment->user->avatar)
                                <img src="{{ asset('storage/avatars/' . $comment->user->avatar) }}" 
                                     alt="{{ $comment->user->name }}" 
                                     class="post-avatar"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="avatar-placeholder" style="display: none;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            @elseif($comment->user)
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            @else
                                <div class="avatar-placeholder">?</div>
                            @endif
                            
                            <div class="post-info">
                                <div class="post-title">{{ $comment->title }}</div>
                                <div class="post-content">{{ $comment->content }}</div>
                                <div class="post-meta">
                                    <span class="post-author">
                                        <x-user-mention name="{{ $authorName }}" />
                                    </span>
                                    <span class="post-time">• {{ $posted_on }}</span>
                                </div>
                            </div>
                            
                            <div class="post-actions">
                                <div class="post-replies-count">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">comment</span>
                                    <span>{{ $comment->replies->count() }}</span>
                                </div>
                                @if($isOwnPost || Auth::user()->role == 'teacher')
                                    <form action="{{ route('forum.destroy', $comment->id) }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="post-action-btn delete-btn" onclick="event.stopPropagation(); return confirm('¿Estás seguro de que quieres eliminar este post?');">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💭</div>
                    <p>Be the first to write on the forum!</p>
                </div>
            @endif
        </div>

        <div class="new-post-section">
            <h3>New Post</h3>
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-control" 
                           placeholder="Enter post title" 
                           required>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" 
                              name="content" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Write your message here..." 
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-primary submit-btn">
                    <span class="material-symbols-outlined">send</span>
                    <span>Post</span>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
