@extends('layouts.app')
@section('main')

<div class="container mt-4">
    <h3>{{ $feedback_type->name }} Feedback</h3>
    <p><strong>Feedback type description:</strong> {{ $feedback_type->description }}</p>

    @switch($feedback_type->level)
    @case('exercise')
        <form action="{{ route('feedback.store', [$exercise->id, $feedback_type->id]) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @if($feedback_type->text_based)
                <div class="card mt-2 mb-2 p-4">
                    <label class="form-check-label">Message</label>
                    <input name="messages[{{ $exercise->id }}][message]" type="text" class="form-control">
                </div>
            @elseif(!$feedback_type->text_based)
                <div class="card mt-2 mb-2 p-4">
                    <label class="form-check-label">Audio file</label>
                    <input class="form-control" type="file" name="audios[{{ $exercise->id }}][audio]" accept="audio/*" id="audio_{{ $exercise->id }}">
                </div>
            @endif
            <div class="mt-4 mb-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary m-1">Save</button>
                <a class="btn btn-secondary m-1" href="{{ route('exercises.show', [$exercise->id]) }}">Cancel</a>
            </div>
        </form>
        @break
    @case('question')
        <form action="{{ route('feedback.store', [$exercise->id, $feedback_type->id]) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @foreach($exercise->questions as $question)
                @if($feedback_type->text_based)
                    <div class="card mt-2 mb-2 p-4">
                        <p>Question {{ $loop->index + 1 }} feedback</p>
                        <label class="form-check-label">Message</label>
                        <input name="messages[{{ $question->id }}][message]" type="text" class="form-control">
                    </div>
                @elseif(!$feedback_type->text_based)
                    <div class="card mt-2 mb-2 p-4">
                        <p>Question {{ $loop->index + 1 }} feedback</p>
                        <div class="mb-3">
                            <label for="audio" class="form-label">Select audio file</label>
                            <input class="form-control" type="file" name="audios[{{ $question->id }}][audio]" accept="audio/*" id="audio_{{ $question->id }}">
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="mt-4 mb-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary m-1">Save</button>
                <a class="btn btn-secondary m-1" href="{{ route('exercises.show', [$exercise->id]) }}">Cancel</a>
            </div>
        </form>
        @break
    @endswitch
</div>

@endsection