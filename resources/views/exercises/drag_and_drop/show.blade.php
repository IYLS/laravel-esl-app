@extends('layouts.app')
@section('main')

<div class="container">
    @include('components.page-header', [
        'title' => 'Drag and drop activity',
        'backRoute' => route('exercises.index', $exercise->section->unit_id)
    ])

    @include('components.exercise-details-card', [
        'exercise' => $exercise,
        'exerciseType' => $exercise->exerciseType
    ])

    <div class="card p-4 m-2">
        <h4>Activity items</h4>
        @forelse($exercise->questions->sortBy('position') as $question)
            <div class="card mt-1 mb-1 p-4">
                <div class="row">
                    @php $question_number = $loop->index + 1; @endphp
                    <div class="col-10 d-flex">
                        <p>{{ $question_number }}. &nbsp;</p>
                        <p class="text-primary"><strong>{{ ucfirst($question->statement) }}</strong></p>:
                        <p>&nbsp;{{ $question->answer }}</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <br>
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
                <p class="text-center text-secondary">No items added.</p>
            </div>
        @endforelse
        @include('components.question-list-actions', ['exercise' => $exercise])
    </div>

    @if($exercise->subtype != '99' and $exercise->subtype != '991')
        @include('feedback.show')
    @endif

    <div class="d-flex justify-content-center">
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@include('modals.questions.add')
@include('modals.questions.set_positions', ["modal_id" => "questions_positions_modal", "questions" => $exercise->questions])

@endsection