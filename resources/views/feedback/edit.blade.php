@extends('layouts.app')
@section('main')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Edit feedback settings</h3>
        <a class="btn btn-link" href="{{ route('exercises.show', $exercise->id) }}">Back to exercise</a>
    </div>

    @if(!$exercise->feedbacks || count($exercise->feedbacks) === 0)
        <div class="alert alert-info">No feedback found for this exercise. Use "Add feedback settings" from the exercise page.</div>
    @endif

    <form enctype="multipart/form-data" action="{{ route('feedback.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-3 mb-3">
            <h5>Exercise-level feedback</h5>
            @php
                $exerciseLevel = $exercise->feedbacks->whereNull('question_id');
            @endphp

            @forelse($exerciseLevel as $fb)
                <div class="mb-3 border rounded p-2">
                    <p class="mb-1"><strong>{{ $fb->feedbackType->name }}</strong></p>

                    @if($fb->feedbackType->text_based)
                        <input type="hidden" name="feedback[{{ $fb->id }}][id]" value="{{ $fb->id }}" />
                        <textarea class="form-control" name="feedback[{{ $fb->id }}][message]" rows="2" required>{{ $fb->message }}</textarea>
                    @endif

                    @if(!$fb->feedbackType->text_based && $fb->feedbackType->name === 'Audio')
                        <p>Current audio: <em>{{ $fb->audio_name ?? 'none' }}</em></p>
                        <input type="file" class="form-control" name="feedback[{{ $fb->id }}][audio]" accept="audio/*" />
                    @endif

                    @if(!$fb->feedbackType->text_based && $fb->feedbackType->name === 'Image')
                        <p>Current image: <em>{{ $fb->image_name ?? 'none' }}</em></p>
                        <input type="file" class="form-control" name="feedback[{{ $fb->id }}][image]" accept="image/*" />
                    @endif
                </div>
            @empty
                <p class="text-muted">No exercise-level feedback entries.</p>
            @endforelse
        </div>

        <div class="card p-3 mb-3">
            <h5>Question-level feedback</h5>
            @if($exercise->questions->isEmpty())
                <p class="text-muted">This exercise has no linked questions yet.</p>
            @else
                @foreach($exercise->questions->sortBy('position') as $question)
                    @php
                        $questionFeedbacks = $exercise->feedbacks->where('question_id', $question->id);
                    @endphp

                    @if($questionFeedbacks->isEmpty())
                        <div class="mb-2">
                            <p class="mb-1"><strong>Question {{ $loop->iteration }}:</strong> {!! $question->statement !!}</p>
                            <p class="text-muted">No feedback configured for this question.</p>
                        </div>
                        @continue
                    @endif

                    <div class="mb-3 border rounded p-2">
                        <p class="mb-1"><strong>Question {{ $loop->iteration }}:</strong> {!! $question->statement !!}</p>

                        @foreach($questionFeedbacks as $fb)
                            <div class="mb-2">
                                <p class="mb-1"><strong>{{ $fb->feedbackType->name }}</strong></p>
                                @if($fb->feedbackType->text_based)
                                    <textarea class="form-control" name="feedback[{{ $fb->id }}][message]" rows="2" required>{{ $fb->message }}</textarea>
                                @else
                                    @if($fb->audio_name)
                                        <p>Current audio: <em>{{ $fb->audio_name }}</em></p>
                                    @endif
                                    @if($fb->image_name)
                                        <p>Current image: <em>{{ $fb->image_name }}</em></p>
                                    @endif
                                    <input type="file" class="form-control" name="feedback[{{ $fb->id }}][audio]" accept="audio/*" />
                                    <input type="file" class="form-control mt-2" name="feedback[{{ $fb->id }}][image]" accept="image/*" />
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>

        <button type="submit" class="btn btn-success">Save changes</button>
        <a href="{{ route('exercises.show', $exercise->id) }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

@endsection