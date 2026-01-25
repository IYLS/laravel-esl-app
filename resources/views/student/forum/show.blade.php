@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    .forum-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-primary);
        text-decoration: none;
        margin-bottom: 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .back-link:hover {
        color: var(--color-hover-primary);
        transform: translateX(-4px);
    }
    .post-detail {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .post-detail-header {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .post-detail-avatar {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .avatar-placeholder {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: white;
        font-size: 1rem;
        font-weight: 600;
    }
    .post-detail-info {
        flex: 1;
        min-width: 0;
    }
    .post-detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.75rem;
        word-wrap: break-word;
    }
    .post-detail-content {
        color: var(--color-text-primary);
        margin-bottom: 1rem;
        line-height: 1.7;
        word-wrap: break-word;
    }
    .post-detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
        font-size: 0.875rem;
        color: var(--color-text-secondary);
    }
    .post-detail-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-left: auto;
    }
    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--color-primary);
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 0.875rem;
    }
    .action-btn:hover {
        background: var(--color-background);
        color: var(--color-hover-primary);
    }
    .action-btn.delete-btn {
        color: var(--color-error);
    }
    .action-btn.delete-btn:hover {
        background: var(--color-error-soft);
        color: var(--color-error);
    }
    .replies-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .replies-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
    }
    .replies-list {
        max-height: 50vh;
        overflow-y: auto;
    }
    .reply-item {
        display: flex;
        gap: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--color-border);
        border-radius: 12px;
        background: var(--color-background);
        transition: all 0.2s ease;
    }
    .reply-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .reply-avatar {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .reply-avatar-placeholder {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .reply-content {
        flex: 1;
        min-width: 0;
    }
    .reply-text {
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.6;
        word-wrap: break-word;
    }
    .reply-meta {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }
    .reply-form-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .reply-form-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-primary);
        margin-bottom: 1rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid var(--color-border);
        padding: 0.75rem;
        font-size: 0.95rem;
        width: 100%;
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
    .empty-replies {
        text-align: center;
        padding: 2rem;
        color: var(--color-text-secondary);
    }
    
    @media (min-width: 768px) {
        .forum-detail-container {
            padding: 0;
        }
        .post-detail-title {
            font-size: 1.75rem;
        }
        .post-detail-header {
            gap: 1rem;
        }
        .post-detail-avatar, .avatar-placeholder {
            width: 56px;
            height: 56px;
            min-width: 56px;
        }
        .submit-btn {
            width: auto;
            min-width: 120px;
        }
    }
</style>

<div class="container mt-2 mb-5">
    <div class="forum-detail-container">
        <a href="{{ route('forum.index') }}" class="back-link">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Back to Forum</span>
        </a>

        <div class="post-detail">
            <div class="post-detail-header">
                @if($comment->user && $comment->user->avatar)
                    <img src="{{ asset('storage/avatars/' . $comment->user->avatar) }}" 
                         alt="{{ $comment->user->name }}" 
                         class="post-detail-avatar"
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
                
                <div class="post-detail-info">
                    <div class="post-detail-title">{{ $comment->title }}</div>
                    <div class="post-detail-content">{{ $comment->content }}</div>
                    <div class="post-detail-meta">
                        <span>posted by </span>
                        @php
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
                        <x-user-mention name="{{ $authorName }}" />
                        <span>•</span>
                        <span>{{ $posted_on }}</span>
                    </div>
                </div>
                
                <div class="post-detail-actions">
                    <div class="action-btn">
                        <span class="material-symbols-outlined" style="font-size: 18px;">comment</span>
                        <span>{{ $replies_number }} replies</span>
                    </div>
                    @if($comment->user_id == $current_user->id || Auth::user()->role == 'teacher')
                        <form action="{{ route('forum.destroy', $comment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este post?');">
                                <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                <span>Delete</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="replies-section">
            <h3>Replies ({{ $replies_number }})</h3>
            <div class="replies-list">
                @forelse($replies as $reply)
                    @php
                        if ($reply->created_at->diffInSeconds(Carbon::now()) <= 59) {
                            $reply_time = $reply->created_at->diffInSeconds(Carbon::now()) == 0 
                                ? "just now" 
                                : $reply->created_at->diffInSeconds(Carbon::now()) . " seconds ago";
                        } elseif ($reply->created_at->diffInMinutes(Carbon::now()) <= 59) {
                            $reply_time = $reply->created_at->diffInMinutes(Carbon::now()) . " minutes ago";
                        } elseif ($reply->created_at->diffInHours(Carbon::now()) <= 23) {
                            $reply_time = $reply->created_at->diffInHours(Carbon::now()) . " hours ago";
                        } elseif ($reply->created_at->diffInDays(Carbon::now()) >= 1) {
                            $reply_time = $reply->created_at->diffInDays(Carbon::now()) == 1 
                                ? "yesterday" 
                                : $reply->created_at->diffInDays(Carbon::now()) . " days ago";
                        } else {
                            $reply_time = $reply->created_at->format('M d, Y');
                        }
                    @endphp
                    <div class="reply-item">
                        @if($reply->user && $reply->user->avatar)
                            <img src="{{ asset('storage/avatars/' . $reply->user->avatar) }}" 
                                 alt="{{ $reply->user->name }}" 
                                 class="reply-avatar"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="reply-avatar-placeholder" style="display: none;">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                        @elseif($reply->user)
                            <div class="reply-avatar-placeholder">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                        @else
                            <div class="reply-avatar-placeholder">?</div>
                        @endif
                        
                        <div class="reply-content">
                            <div class="reply-text">{{ $reply->content }}</div>
                            <div class="reply-meta">
                                @if($reply->user)
                                    <x-user-mention name="{{ $reply->user->name }}" />
                                    <span> • </span>
                                @endif
                                <span>{{ $reply_time }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-replies">
                        <p>No replies yet. Be the first to reply!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="reply-form-section">
            <h3>Reply to this post</h3>
            <form action="{{ route('replies.store', $comment->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="content" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Write your reply here..." 
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-primary submit-btn">
                    <span class="material-symbols-outlined">send</span>
                    <span>Reply</span>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
