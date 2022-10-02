@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    #forum-content-container { height: 60vh; }
    #forum-comment-container { height: 20%; }
    .forum-self-comment { background-color: #f2f5fa !important; }
    #forum-reply-list { height: 30vh; }
</style>
<div class="container mt-2">
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('forum.index') }}">Go back</a>
        </div>
    </div>
</div>
<div class="container mt-3 border">
    <h3 class="m-4">{{ $comment->title }}</h3>
    <p class="m-4">{{ $comment->content }}</p>
    <div class="row m-3">
        <div class="col-6 d-flex align-items-center justify-content-start">
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
        <div class="col-6 d-flex align-items-center justify-content-end">
            <div class="d-flex me-1">
                <i class="mdi mdi-18px mdi-comment-multiple-outline me-1 text-primary"></i><p class="text-primary"><small>{{ $replies_number }} replies</small></p>
            </div>
            @if ($comment->user_id == $current_user->id)
                <div class="d-flex me-1">
                    <form action="{{ route('forum.destroy', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn d-flex" type="submit">
                            <i class="mdi mdi-delete text-danger"></i><p class="text-danger"><small>delete</small></p>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="overflow-auto border mt-4 mb-4" id="forum-reply-list">
        <h5 class="m-2">Replies to this post</h5>
        @forelse($replies as $reply)
            <div class="border rounded p-2 m-2 d-flex">
                <p>{{ $reply->content }}</p>
                <div class="d-flex">
                    <p class="text-secondary ms-1"><small>{{ "@".$reply->user->user_id . " on " }}</small></p>
                    <p class="text-secondary ms-1"><small>{{ $reply->created_at }}</small></p>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center">
                <p class="text-secondary"><small>No replies yet.</small></p>
            </div>
        @endforelse
    </div>
</div>

<div class="container mt-3 pt-2 pb-2" id="forum-comment-container">
    <h5>Reply to this post</h5>
    <form action="{{ route('replies.store', $comment->id) }}" method="POST" class="row">
        @csrf
        <div class="col-11">
            <textarea class="form-control" name="content" type="text" placeholder="Type here your reply"></textarea>
        </div>
        <button class="col-1 text-center btn btn-primary" type="submit">
            <i class="mdi mdi-24px mdi-send"></i>
        </button>
    </form>
</div>


@endsection