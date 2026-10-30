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

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert">
            <span class="material-symbols-outlined" style="font-size:20px">check_circle</span>
            <small>{{ session('success') }}</small>
        </div>
    @endif

    @if(!$exercise->feedbacks || count($exercise->feedbacks) === 0)
        <div class="alert alert-warning d-flex align-items-center gap-2 py-2 px-3 mb-3">
            <span class="material-symbols-outlined" style="font-size:18px">warning</span>
            <small>No feedback found for this exercise. Use <strong>Add feedback settings</strong> from the exercise page, or add types below.</small>
        </div>
    @endif

    <form enctype="multipart/form-data" action="{{ route('feedback.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if($hasAnyAppendOption)
            <div class="alert alert-light border d-flex align-items-start gap-2 py-3 px-3 mb-4" role="note">
                <span class="material-symbols-outlined text-primary flex-shrink-0" style="font-size:24px">tips_and_updates</span>
                <div class="small">
                    <strong class="d-block mb-1">Add feedback you skipped earlier</strong>
                    <span class="text-muted">Expand any dashed section to configure a new type. Empty fields are ignored. Use <strong>Save changes</strong> at the bottom to apply updates and new entries together.</span>
                </div>
            </div>
        @endif

        {{-- ── Exercise-level feedback (existing) ─────────────────────────── --}}
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

        {{-- ── Add exercise-level types (not yet configured) ───────────────── --}}
        @if($missingExerciseTypes->isNotEmpty() || $showDictationKnowledgeImage)
            <div class="card shadow-sm mb-4 border-2 border-dashed rounded-3" style="border-color: rgba(var(--bs-primary-rgb, 13, 110, 253), 0.35) !important;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-start gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary p-3 flex-shrink-0">
                            <span class="material-symbols-outlined" style="font-size:36px">post_add</span>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h5 class="mb-1">Add exercise-wide feedback</h5>
                            <p class="text-muted small mb-3 mb-md-4">These types apply to the whole exercise (for example messages after Check). Expand a row to add one.</p>

                            @foreach($missingExerciseTypes as $type)
                                <details class="border rounded-3 mb-2 bg-body-secondary bg-opacity-25">
                                    <summary class="px-3 py-2 fw-semibold small user-select-none d-flex align-items-center justify-content-between gap-2" style="cursor:pointer;list-style:none;">
                                        <span class="d-flex align-items-center gap-2">
                                            <span class="material-symbols-outlined text-primary" style="font-size:20px">add_circle_outline</span>
                                            {{ $type->name }}
                                        </span>
                                        <button class="btn btn-link btn-sm p-0 text-decoration-none" type="button"
                                            data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal"
                                            onclick="event.stopPropagation();">
                                            <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                                        </button>
                                    </summary>
                                    <div class="px-3 pb-3 pt-1 border-top bg-body">
                                        @if($type->text_based)
                                            <label class="form-label small text-muted mb-1">Message</label>
                                            <textarea class="form-control" rows="2" name="append[exercise][{{ $type->id }}][message]"
                                                placeholder="Enter {{ $type->name }}…"></textarea>
                                        @endif
                                    </div>
                                </details>
                            @endforeach

                            @if($showDictationKnowledgeImage)
                                @php $knowledgeType = $feedbackTypes->firstWhere('id', 7); @endphp
                                <details class="border rounded-3 mb-0 bg-body-secondary bg-opacity-25">
                                    <summary class="px-3 py-2 fw-semibold small user-select-none d-flex align-items-center justify-content-between gap-2" style="cursor:pointer;list-style:none;">
                                        <span class="d-flex align-items-center gap-2">
                                            <span class="material-symbols-outlined text-primary" style="font-size:20px">image</span>
                                            @if($knowledgeType) {{ $knowledgeType->name }} @else Knowledge of correct response @endif
                                            <span class="badge rounded-pill text-bg-secondary fw-normal" style="font-size:10px">Dictation Cloze · image</span>
                                        </span>
                                        @if($knowledgeType)
                                            <button class="btn btn-link btn-sm p-0 text-decoration-none" type="button"
                                                data-bs-toggle="modal" data-bs-target="#feedback_description_7_modal"
                                                onclick="event.stopPropagation();">
                                                <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                                            </button>
                                        @endif
                                    </summary>
                                    <div class="px-3 pb-3 pt-1 border-top bg-body">
                                        <p class="text-muted small mb-2">Image shown after three failed attempts (same as initial setup).</p>
                                        <input type="file" class="form-control" accept="image/*" name="append[exercise][7][image]">
                                    </div>
                                </details>
                            @endif
                        </div>
                    </div>
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
                $missingForQ = $missingQuestionTypesByQuestion[$question->id] ?? collect();
            @endphp
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light d-flex align-items-start gap-2">
                    <span class="badge bg-primary rounded-pill mt-1" style="font-size:13px;min-width:28px">{{ $qIndex }}</span>
                    <div class="flex-grow-1">
                        <span class="fw-semibold">{!! $question->statement !!}</span>
                    </div>
                </div>

                <div class="card-body">
                    @if($questionFeedbacks->isEmpty())
                        <p class="text-muted mb-0"><small>No feedback configured for this question yet.</small></p>
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

                    @if($missingForQ->isNotEmpty())
                        <div class="mt-3 pt-3 border-top border-dashed">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-primary" style="font-size:22px">library_add</span>
                                <span class="fw-semibold">Add feedback for this question</span>
                            </div>
                            <p class="text-muted small mb-3">Only types you did not configure initially. Leave collapsed or empty to skip.</p>

                            @foreach($missingForQ as $type)
                                <details class="border rounded-3 mb-2 bg-body-secondary bg-opacity-25">
                                    <summary class="px-3 py-2 fw-semibold small user-select-none d-flex align-items-center justify-content-between gap-2" style="cursor:pointer;list-style:none;">
                                        <span class="d-flex align-items-center gap-2">
                                            <span class="material-symbols-outlined text-primary" style="font-size:20px">add_circle_outline</span>
                                            {{ $type->name }}
                                        </span>
                                        <button class="btn btn-link btn-sm p-0 text-decoration-none" type="button"
                                            data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal"
                                            onclick="event.stopPropagation();">
                                            <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                                        </button>
                                    </summary>
                                    <div class="px-3 pb-3 pt-1 border-top bg-body">
                                        @if($type->text_based && (int) $type->id === 5)
                                            <p class="text-muted small mb-2">One message per incorrect option (required for each row you fill).</p>
                                            @foreach($question->alternatives as $alternative)
                                                @if(!$alternative->correct_alt)
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="text-muted small" style="min-width:22px">{{ $loop->iteration }}.</span>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="append[question][5][{{ $question->id }}][{{ $alternative->id }}][message]"
                                                            placeholder="Explanation for incorrect option {{ $loop->iteration }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        @elseif($type->text_based)
                                            <label class="form-label small text-muted mb-1">Message</label>
                                            <textarea class="form-control" rows="2"
                                                name="append[question][{{ $type->id }}][{{ $question->id }}][message]"
                                                placeholder="Enter {{ $type->name }}…"></textarea>
                                        @else
                                            <label class="form-label small text-muted mb-1">Audio file</label>
                                            <input class="form-control" type="file" accept="audio/*"
                                                name="append[question][{{ $type->id }}][{{ $question->id }}][audio]">
                                        @endif
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        @endif

        <div class="d-flex flex-wrap gap-2 mt-2 mb-5">
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle">save</span> Save changes
            </button>
            <a href="{{ route('exercises.show', $exercise->id) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

{{-- Description modals — all types (for existing + newly addable) --}}
@foreach($feedbackTypes as $type)
    @include('modals.exercises.feedback_description', ['type' => $type->name, 'description' => $type->description, 'id' => $type->id])
@endforeach

@endsection
