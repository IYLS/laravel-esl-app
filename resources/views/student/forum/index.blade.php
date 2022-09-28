@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    #forum-content-container { height: 64vh; }
    #forum-comment-container { height: 13vh; }
    .forum-self-comment { background-color: #f0f5fc !important; }
</style>

<div class="container">
    <h3 class="m-3">Students Forum</h3>
    <div class="overflow-auto border mt-4 mb-4" id="forum-content-container">
        @forelse($comments as $comment)
            <div class="card ps-3 pe-3 pt-1 pb-1 m-3 @if($comment->user_id == $current_user->id) forum-self-comment @endif">
                <h5 class="mt-1">{{ $comment->title }}</h5>
                <p>{{ $comment->content }}</p>
                <div class="row col-12">
                    <div class="col-8 d-flex align-items-center justify-content-start">
                        @if($comment->user_id == $current_user->id)
                            @php $posted_by = "posted by @me"; @endphp
                        @else
                            @php $posted_by = "posted by @" . $comment->user->user_id; @endphp
                        @endif
            
                        @if ($comment->created_at->diffInSeconds(Carbon::now()) <= 59)
                            @if ($comment->created_at->diffInSeconds(Carbon::now()) == 0)
                                @php $posted_on = " just now"; @endphp
                            @else
                                @php $posted_on = " " . $comment->created_at->diffInSeconds(Carbon::now()) . " seconds ago"; @endphp
                            @endif
                        @elseif ($comment->created_at->diffInMinutes(Carbon::now()) <= 59)
                            @php $posted_on = " " . $comment->created_at->diffInMinutes(Carbon::now()) . " minutes ago"; @endphp
                        @elseif ($comment->created_at->diffInHours(Carbon::now()) <= 23)
                            @php $posted_on = " " . $comment->created_at->diffInHours(Carbon::now()) . " hours ago"; @endphp
                        @elseif ($comment->created_at->diffInDays(Carbon::now()) >= 1)
                            @if ($comment->created_at->diffInDays(Carbon::now()) == 1)
                                @php $posted_on = " yesterday"; @endphp
                            @else
                                @php $posted_on = " " . $comment->created_at->diffInDays(Carbon::now()) . " days ago"; @endphp
                            @endif
                        @endif
                    <p class="text-secondary"><small>{{ $posted_by . $posted_on }}</small></p>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-end">
                        <a class="btn d-flex" href="{{ route('forum.show', $comment->id) }}">
                            <i class="mdi mdi-18px mdi-comment-multiple-outline me-1 text-primary"></i><p class="text-primary"><small>{{ $comment->replies->count() }} replies</small></p>
                        </a>
                        @if ($comment->user_id == $current_user->id)
                            <form action="{{ route('forum.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn d-flex" type="submit">
                                    <i class="mdi mdi-delete text-danger"></i><p class="text-danger"><small>delete</small></p>
                                </button>
                            </form>
                        @endif
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