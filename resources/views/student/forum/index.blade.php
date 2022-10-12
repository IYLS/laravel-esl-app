@extends('layouts.app')
@section('main')

@php use Carbon\Carbon; @endphp

<style>
    #forum-content-container { height: 60vh; }
    #forum-comment-container { height: 20%; }
    .forum-self-comment { background-color: #f0f5fc !important; }
</style>

<div class="container">
    <h3 class="m-3">Students Forum</h3>
    <div class="overflow-auto border mt-4 mb-4" id="forum-content-container">
        @if(isset($comments) and $comments != null)
            @forelse($comments as $comment)
                <div class="card ps-3 pe-3 pt-1 pb-1 m-3 @if($comment->user_id == $current_user->id) forum-self-comment @endif">
                    <h5 class="mt-1">{{ $comment->title }}</h5>
                    <p>{{ $comment->content }}</p>
                    <div class="row col-12">
                        <div class="col-12 col-md-8 d-flex align-items-center justify-content-start">
                            @php $posted_by = ""; @endphp
                            @if(isset($comment->user->name) and $comment->user->name == $current_user->name)
                                @php $posted_by = "posted by @me"; @endphp
                            @elseif(isset($comment->user->name) and $comment->user->name != $current_user->name)
                                @php $posted_by = "posted by @" . $comment->user->name; @endphp
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
                        <div class="col-12 col-md-4 d-flex align-items-center justify-content-end">
                            <a class="btn d-flex" href="{{ route('forum.show', $comment->id) }}">
                                <i class="mdi mdi-18px mdi-comment-multiple-outline me-1 text-primary"></i><p class="text-primary"><small>{{ $comment->replies->count() }} replies</small></p>
                            </a>
                            @if ($comment->user_id == $current_user->id or Auth::user()->role == 'teacher')
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
        
            @else

            <p class="text-center text-secondary"><small>Be the first to write on the forum!</small></p>
        @endif
    </div>
    <div class="p-1" id="forum-comment-container">
        <h5 class="m-1">New post</h5>
        <form action="{{ route('forum.store') }}" method="POST" class="row">
            @csrf
            <div class="col-11">
                <input class="form-control m-1" name="title" type="text" placeholder="Title" required>
                <textarea class="form-control m-1" name="content" type="text" placeholder="Content" required></textarea>
            </div>
            <button class="col-1 text-center btn btn-primary" type="submit">
                <i class="mdi mdi-24px mdi-send"></i>
            </button>
        </form>
    </div>
</div>

@endsection