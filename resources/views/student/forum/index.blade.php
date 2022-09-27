@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    #forum-content-container { height: 64vh; }
    #forum-comment-container { height: 13vh; }
    .forum-self-comment { background-color: #c3cceb !important; }
</style>

<div class="container">
    <h3 class="m-3">Students Forum</h3>
    <div class="overflow-auto border mt-4 mb-4" id="forum-content-container">
        @forelse($comments as $comment)
            <div class="card ps-3 pe-3 pt-1 pb-1 m-3 @if($comment->user_id == $current_user->id) forum-self-comment @endif">
                <h5>{{ $comment->title }}</h5>
                <p>{{ $comment->content }}</p>
                <div class="row col-12">
                    <div class="col-4 d-flex align-items-center justify-content-start">
                        @if($comment->user_id == $current_user->id)
                            <p class="text-center text-secondary"><small>posted by @me</small></p>
                        @else
                            <p class="text-center text-secondary"><small>posted by {{ "@".$comment->user->user_id }}</small></p>
                        @endif
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        @if ($comment->created_at->diffInSeconds(Carbon::now()) <= 59)
                            @if ($comment->created_at->diffInSeconds(Carbon::now()) == 0)
                                <p class="text-secondary text-center"><small>posted just now</small></p>
                            @else
                                <p class="text-secondary text-center"><small>posted {{ $comment->created_at->diffInSeconds(Carbon::now()) }} seconds ago</small></p>
                            @endif
                        @elseif ($comment->created_at->diffInMinutes(Carbon::now()) <= 59)
                            <p class="text-secondary text-center"><small>posted {{ $comment->created_at->diffInMinutes(Carbon::now()) }} minutes ago</small></p>
                        @elseif ($comment->created_at->diffInHours(Carbon::now()) <= 23)
                            <p class="text-secondary text-center"><small>posted {{ $comment->created_at->diffInHours(Carbon::now()) }} hours ago</small></p>
                        @elseif ($comment->created_at->diffInDays(Carbon::now()) >= 1)
                            @if ($comment->created_at->diffInDays(Carbon::now()) == 1)
                                <p class="text-secondary text-center"><small>posted yesterday</small></p>
                            @else
                                <p class="text-secondary text-center"><small>posted {{ $comment->created_at->diffInDays(Carbon::now()) }} days ago</small></p>
                            @endif
                        @endif
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end">
                        <a class="btn d-flex" href="{{ route('forum.show', $comment->id) }}">
                            <i class="mdi mdi-18px mdi-comment-multiple-outline me-1"></i><p><small>{{ $comment->replies->count() }} replies</small></p>
                        </a>
                        <a class="btn d-flex" href="{{ route('forum.show', $comment->id) }}">
                            <i class="mdi mdi-18px mdi-reply me-1"></i><p><small>reply this</small></p>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-secondary"><small>Be the first to write on the forum!</small></p>
        @endforelse
    </div>
    <div class="p-1" id="forum-comment-container">
        <h5 class="m-1">New post</h5>
        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-10">
                    <input class="form-control m-1" name="title" type="text" placeholder="Title" required>
                    <textarea class="form-control m-1" name="content" type="text" placeholder="Content" required></textarea>
                </div>
                <div class="col-1 d-grid gap-2 text-center">
                    <button class="btn btn-primary m-2" type="submit">
                        <i class="mdi mdi-24px mdi-send"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection