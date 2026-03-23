@extends('layouts.app')
@section('main')

<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-2 mb-3 p-2">
        <div>
            <h3 class="mb-0">Edit Feedback Settings</h3>
            <p class="text-secondary mb-0 mt-1"><small>{{ $exercise->title }}</small></p>
        </div>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('exercises.show', $exercise->id) }}">
            <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">arrow_back</span> Go back
        </a>
    </div>

    @if(!$exercise->feedbacks || count($exercise->feedbacks) === 0)
        <div class="alert alert-warning d-flex align-items-center gap-2 py-2 px-3 mb-3">
            <span class="material-symbols-outlined" style="font-size:18px">warning</span>
            <small>No feedback found for this exercise. Use <strong>Add feedback settings</strong> from the exercise page.</small>
        </div>
    @endif

    <form enctype="multipart/form-data" action="{{ route('feedback.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ── Exercise-level feedback ─────────────────────────────────────── --}}
        @php $exerciseLevel = $exercise->feedbacks->whereNull('question_id'); @endphp
        @if($exerciseLevel->isNotEmpty())
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:20px">layers</span>
                <strong>Exercise-level feedback</strong>
            </div>
            <div class="card-body">
                @foreach($exerciseLevel as $fb)
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex align-items-center gap-1">
                            {{ $fb->feedbackType->name }}
                            <button class="btn btn-link btn-sm p-0 ms-1" type="button"
                                data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $fb->feedbackType->id }}_modal">
                                <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                            </button>
                        </label>
                        @if($fb->feedbackType->text_based)
                            <input type="hidden" name="feedback[{{ $fb->id }}][id]" value="{{ $fb->id }}" />
                            <textarea class="form-control" name="feedback[{{ $fb->id }}][message]" rows="2" required>{{ $fb->message }}</textarea>
                        @elseif($fb->feedbackType->name === 'Audio')
                            <p class="text-muted small mb-1">Current: <em>{{ $fb->audio_name ?? 'none' }}</em></p>
                            <input type="file" class="form-control" name="feedback[{{ $fb->id }}][audio]" accept="audio/*" />
                        @elseif($fb->feedbackType->name === 'Image')
                            <p class="text-muted small mb-1">Current: <em>{{ $fb->image_name ?? 'none' }}</em></p>
                            <input type="file" class="form-control" name="feedback[{{ $fb->id }}][image]" accept="image/*" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Question-level feedback ──────────────────────────────────────── --}}
        @if($exercise->questions->isNotEmpty())
        <div class="mb-2">
            <h5 class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:22px">help_outline</span>
                Question-level feedback
            </h5>
            <p class="text-muted small">Review and update feedback for each question.</p>
        </div>

        @foreach($exercise->questions->sortBy('position') as $question)
            @php
                $questionFeedbacks = $exercise->feedbacks->where('question_id', $question->id);
                $qIndex = $loop->index + 1;
            @endphp
            <div class="card shadow-sm mb-3">
                {{-- Question header --}}
                <div class="card-header bg-light d-flex align-items-start gap-2">
                    <span class="badge bg-primary rounded-pill mt-1" style="font-size:13px;min-width:28px">{{ $qIndex }}</span>
                    <div class="flex-grow-1">
                        <span class="fw-semibold">{!! $question->statement !!}</span>
                    </div>
                </div>

                <div class="card-body">
                    @if($questionFeedbacks->isEmpty())
                        <p class="text-muted mb-0"><small>No feedback configured for this question.</small></p>
                    @else
                        @foreach($questionFeedbacks as $fb)
                            <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                <div class="d-flex align-items-center gap-1 mb-2">
                                    <span class="fw-semibold text-secondary small text-uppercase" style="letter-spacing:.04em">{{ $fb->feedbackType->name }}</span>
                                    <button class="btn btn-link btn-sm p-0 ms-1" type="button"
                                        data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $fb->feedbackType->id }}_modal">
                                        <span class="material-symbols-outlined text-primary" style="font-size:16px">info</span>
                                    </button>
                                </div>
                                @if($fb->feedbackType->text_based)
                                    <textarea class="form-control" name="feedback[{{ $fb->id }}][message]" rows="2" required>{{ $fb->message }}</textarea>
                                @else
                                    @if($fb->audio_name)
                                        <p class="text-muted small mb-1">Current audio: <em>{{ $fb->audio_name }}</em></p>
                                    @endif
                                    @if($fb->image_name)
                                        <p class="text-muted small mb-1">Current image: <em>{{ $fb->image_name }}</em></p>
                                    @endif
                                    <input type="file" class="form-control" name="feedback[{{ $fb->id }}][audio]" accept="audio/*" />
                                    <input type="file" class="form-control mt-2" name="feedback[{{ $fb->id }}][image]" accept="image/*" />
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
        @endif

        <div class="d-flex gap-2 mt-2 mb-5">
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle">save</span> Save changes
            </button>
            <a href="{{ route('exercises.show', $exercise->id) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

{{-- ── Description modals — rendered ONCE, outside all loops ──────────── --}}
@php $uniqueFeedbackTypes = $exercise->feedbacks->pluck('feedbackType')->unique('id'); @endphp
@foreach($uniqueFeedbackTypes as $type)
    @include('modals.exercises.feedback_description', ['type' => $type->name, 'description' => $type->description, 'id' => $type->id])
@endforeach

@endsection