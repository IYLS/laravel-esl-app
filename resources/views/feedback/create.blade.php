@extends('layouts.app')
@section('main')

<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-2 mb-3 p-2">
        <div>
            <h3 class="mb-0">Feedback Settings</h3>
            <p class="text-secondary mb-0 mt-1"><small>{{ $exercise->title }}</small></p>
        </div>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('exercises.show', $exercise->id) }}">
            <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">arrow_back</span> Go back
        </a>
    </div>

    <div class="alert alert-info d-flex align-items-center gap-2 py-2 px-3 mb-3">
        <span class="material-symbols-outlined" style="font-size:18px">info</span>
        <small>Use the <strong>ⓘ</strong> buttons to get more info about each feedback type.</small>
    </div>

    <form enctype="multipart/form-data" action="{{ route('feedback.store', $exercise->id) }}" method="POST">
        @csrf

        {{-- ── Exercise-level feedback ─────────────────────────────────────── --}}
        @php $exerciseTypes = $feedback_types->where('level', 'exercise'); @endphp
        @if($exerciseTypes->isNotEmpty() || ($exercise->exercise_type_id == 3 && $exercise->subtype == 1))
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:20px">layers</span>
                <strong>Exercise-level feedback</strong>
            </div>
            <div class="card-body">
                @forelse($exerciseTypes as $type)
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-flex align-items-center gap-1">
                            {{ $type->name }}
                            <button class="btn btn-link btn-sm p-0 ms-1" type="button"
                                data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                            </button>
                        </label>
                        @if($type->text_based)
                            <input type="text" class="form-control" name="data[exercise][{{ $type->id }}][message]"
                                required placeholder="Enter {{ $type->name }} message…">
                        @endif
                    </div>
                @empty
                @endforelse

                {{-- Knowledge of correct response — Dictation Cloze only --}}
                @if($exercise->exercise_type_id == 3 && $exercise->subtype == 1)
                    @php $knowledge_type = $feedback_types->where('id', 7)->first(); @endphp
                    @if($knowledge_type)
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-flex align-items-center gap-1">
                                {{ $knowledge_type->name }}
                                <span class="badge bg-secondary ms-1" style="font-size:11px">Image · Exercise level</span>
                                <button class="btn btn-link btn-sm p-0 ms-1" type="button"
                                    data-bs-toggle="modal" data-bs-target="#feedback_description_7_modal">
                                    <span class="material-symbols-outlined text-primary" style="font-size:18px">info</span>
                                </button>
                            </label>
                            <p class="text-muted small mb-1">Upload an image showing all correct answers. Shown after 3 failed attempts.</p>
                            <input class="form-control" type="file" id="knowledge_image" accept="image/*" name="data[exercise][7][image]">
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif

        {{-- ── Question-level feedback ──────────────────────────────────────── --}}
        @php $questionTypes = $feedback_types->where('level', 'question'); @endphp
        @if($questionTypes->isNotEmpty())
        <div class="mb-2">
            <h5 class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:22px">help_outline</span>
                Question-level feedback
            </h5>
            <p class="text-muted small">Configure feedback for each question independently.</p>
        </div>

        @forelse($exercise->questions->sortBy('position') as $question)
            @php $qIndex = $loop->index + 1; @endphp
            <div class="card shadow-sm mb-3">
                {{-- Question header --}}
                <div class="card-header bg-light d-flex align-items-start gap-2">
                    <span class="badge bg-primary rounded-pill mt-1" style="font-size:13px;min-width:28px">{{ $qIndex }}</span>
                    <div class="flex-grow-1">
                        @if($exercise->exercise_type_id == 2 && $exercise->subtype == 1)
                            <ol type="I" class="mb-1 mt-0 ps-3">
                                @foreach(explode(";", $question->statement) as $st)
                                    <li><span class="fw-semibold">{{ $st }}</span></li>
                                @endforeach
                            </ol>
                            <ol type="1" class="mb-0 ps-3">
                                @foreach($question->alternatives as $alt)
                                    <li class="text-secondary small">{{ $alt->title }}</li>
                                @endforeach
                            </ol>
                        @else
                            <span class="fw-semibold">{!! $question->statement !!}</span>
                        @endif
                    </div>
                </div>

                {{-- Feedback types for this question --}}
                <div class="card-body">
                    @foreach($questionTypes as $type)
                        <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                            <div class="d-flex align-items-center gap-1 mb-2">
                                <span class="fw-semibold text-secondary small text-uppercase" style="letter-spacing:.04em">{{ $type->name }}</span>
                                <button class="btn btn-link btn-sm p-0 ms-1" type="button"
                                    data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                    <span class="material-symbols-outlined text-primary" style="font-size:16px">info</span>
                                </button>
                            </div>

                            @if($type->text_based && $type->id == 5)
                                {{-- Explanatory: one input per incorrect alternative --}}
                                @foreach($question->alternatives as $alternative)
                                    @if(!$alternative->correct_alt)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="text-muted small" style="min-width:22px">{{ $loop->index + 1 }}.</span>
                                            <input type="text" class="form-control form-control-sm"
                                                name="data[question][{{ $type->id }}][{{ $question->id }}][{{ $alternative->id }}][message]"
                                                required placeholder="Explanation for incorrect option {{ $loop->index + 1 }}">
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="text-muted small" style="min-width:22px">{{ $loop->index + 1 }}.</span>
                                            <input type="text" class="form-control form-control-sm text-muted"
                                                value="Option {{ $loop->index + 1 }} is correct" disabled>
                                        </div>
                                    @endif
                                @endforeach

                            @elseif($type->text_based)
                                <input type="text" class="form-control"
                                    name="data[question][{{ $type->id }}][{{ $question->id }}][message]"
                                    required placeholder="Enter {{ $type->name }} message…">

                            @else
                                <div class="col-12 col-md-8">
                                    <label class="form-label small text-muted">Audio file</label>
                                    <input class="form-control" type="file" accept="audio/*"
                                        name="data[question][{{ $type->id }}][{{ $question->id }}][audio]" required>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="card p-3 text-center text-muted">
                <small>No questions linked to this exercise.</small>
            </div>
        @endforelse
        @endif

        <div class="d-flex gap-2 mt-2 mb-5">
            <button class="btn btn-primary" type="submit">
                <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle">save</span> Save feedback
            </button>
            <a class="btn btn-outline-secondary" href="{{ route('exercises.show', $exercise->id) }}">Cancel</a>
        </div>
    </form>
</div>

{{-- ── Description modals — rendered ONCE, outside all loops ──────────── --}}
@foreach($feedback_types as $type)
    @include('modals.exercises.feedback_description', ['type' => $type->name, 'description' => $type->description, 'id' => $type->id])
@endforeach

@endsection