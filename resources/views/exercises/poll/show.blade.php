@extends('layouts.app')
@section('main')

<div class="container">
    @include('components.page-header', [
        'title' => 'Poll activity (Likert 1-7)',
        'backRoute' => route('exercises.index', $exercise->section->unit_id)
    ])

    @include('components.exercise-details-card', [
        'exercise' => $exercise,
        'exerciseType' => $exercise->exerciseType
    ])

    <div class="card p-4 m-2">
        <h4>Poll questions</h4>
        @forelse($exercise->questions->sortBy('position') as $question)
            @php $question_number = $loop->index + 1; @endphp
            <div class="card mt-1 mb-1 p-4">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <h6>{{ $question_number }}. {!! $question->statement !!}</h6>
                        <p class="text-muted mb-0"><small>Scale: 1 — 2 — 3 — 4 — 5 — 6 — 7</small></p>
                    </div>
                    <div class="col-12 col-md-2 d-flex justify-content-center align-items-center">
                        @include('components.question-actions', [
                            'question' => $question,
                            'questionNumber' => $question_number,
                            'exercise' => $exercise
                        ])
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No questions added yet.</p>
            </div>
        @endforelse

        @include('components.question-list-actions', ['exercise' => $exercise])
    </div>

    <div class="d-flex justify-content-center">
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@foreach($exercise->questions->sortBy('position') as $question)
    @php $question_number = $loop->index + 1; @endphp
    @include('modals.questions.delete_confirmation', ['title' => 'Confirmation request', 'body' => "Please confirm you want to delete question number $question_number.", 'button_target_id' => "delete_question_$question->id", 'route' => route('questions.destroy', [$exercise->id, $question->id])])
    @include('modals.questions.edit', ['button_target_id' => "edit_question_$question->id", 'alternatives' => $question->alternatives ?? []])
@endforeach
@include('modals.questions.add')
@include('modals.questions.set_positions', ["modal_id" => "questions_positions_modal", "questions" => $exercise->questions])

@endsection
