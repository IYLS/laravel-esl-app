@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    #forum-content-container {
        height: 70vh;
    }

    #forum-comment-container {
        height: 13vh;
    }

    .forum-self-comment {
        background-color: #c3cceb !important;
    }
</style>

<div class="container">
    <h3>Students Forum</h3>
    <div class="overflow-auto border mt-4 mb-4" id="forum-content-container">
        @forelse($comments as $comment)
            <div class="card p-3 m-4 @if($comment->user_id == $current_user->id) forum-self-comment @endif">
                <h4>{{ $comment->title }}</h4>
                <p>{{ $comment->content }}</p>
                <div class="row col-12">
                    <div class="col-6">
                        @if($comment->user_id == $current_user->id)
                            <p class="text-start"><small>posted by<strong class="text-primary"> me</strong></small></p>
                        @else
                            <p class="text-start"><small>posted by <strong class="text-primary">{{ "@".$comment->user->user_id }}</strong></small></p>
                        @endif
                    </div>
                    <div class="col-6">
                        @if ($comment->created_at->diffInSeconds(Carbon::now()) <= 59)
                            @if ($comment->created_at->diffInSeconds(Carbon::now()) == 0)
                                <p class="text-secondary text-end"><small>posted just now</small></p>
                            @else
                                <p class="text-secondary text-end"><small>posted {{ $comment->created_at->diffInSeconds(Carbon::now()) }} seconds ago</small></p>
                            @endif
                        @elseif ($comment->created_at->diffInMinutes(Carbon::now()) <= 59)
                            <p class="text-secondary text-end"><small>posted {{ $comment->created_at->diffInMinutes(Carbon::now()) }} minutes ago</small></p>
                        @elseif ($comment->created_at->diffInHours(Carbon::now()) <= 23)
                            <p class="text-secondary text-end"><small>posted {{ $comment->created_at->diffInHours(Carbon::now()) }} hours ago</small></p>
                        @elseif ($comment->created_at->diffInDays(Carbon::now()) >= 1)
                            @if ($comment->created_at->diffInDays(Carbon::now()) == 1)
                                <p class="text-secondary text-end"><small>posted yesterday</small></p>
                            @else
                                <p class="text-secondary text-end"><small>posted {{ $comment->created_at->diffInDays(Carbon::now()) }} days ago</small></p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-secondary"><small>Be the first to write on the forum!</small></p>
        @endforelse
    </div>
    <div class="border rounded p-1" id="forum-comment-container">
        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-10">
                    <input class="form-control m-1" name="title" type="text" placeholder="Título del post">
                    <textarea class="form-control m-1" name="content" type="text" placeholder="Contenido del post"></textarea>
                </div>
                <div class="col-1 d-grid gap-2 text-center">
                    <button class="btn btn-primary m-2" type="submit">Post</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection