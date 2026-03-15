@extends('layouts.app')
@section('main')

<div class="container">
    @include('components.page-header', [
        'title' => 'Multiple choice activity',
        'backRoute' => route('exercises.index', $exercise->section->unit_id)
    ])

    @include('components.exercise-details-card', [
        'exercise' => $exercise,
        'exerciseType' => $exercise->exerciseType
    ])

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($exercise->questions->sortBy('position') as $question)
            @php $question_number = $loop->index + 1; @endphp

            @if($exercise->subtype == 1 or $exercise->subtype == 4 or $exercise->subtype == 99 or $exercise->subtype == 3)
                <div class="card mt-1 mb-1 p-4">
                    @if(isset($e->video_name) and $e->video_name != null)
                        <video title="Video" allowfullscreen controls>
                            <source src="{{ asset('storage/files') . "/" . $e->video_name }}">
                        </video>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-10">
                            {!! $question->statement !!}
                            <ol type="a">
                                @forelse($question->alternatives as $alt)
                                    <li>
                                        @if($alt->correct_alt) <strong class="text-primary">{{ $alt->title }}</strong>
                                        @else {{ $alt->title }}
                                        @endif
                                    </li>
                                @empty
                                    <p class="text-secondary"><small>No alternatives added</small></p>
                                @endforelse
                            </ol>
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-center">
                            @include('components.question-actions', [
                                'question' => $question,
                                'questionNumber' => $question_number,
                                'exercise' => $exercise
                            ])
                        </div>
                    </div>
                </div>
            @elseif($exercise->subtype == 2)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            @php
                                $correct_words = explode('/', $question->correct_answer);
                                $words = explode(' ', $question->statement);
                                
                                foreach($words as $key=>$word) {
                                    if($word == ";;" ) {
                                        $words[$key] = "<strong>_________</strong>";
                                    }
                                }

                                $final_string = implode(' ', $words);
                            @endphp
                            
                            <p>{!! $final_string !!}</p>
                            <ol type="a">
                                @forelse($question->alternatives as $alt)
                                    <li>
                                        @if($alt->correct_alt)
                                            <p><strong class="text-primary">{{ $alt->title }}</strong></p>
                                        @else
                                            <p>{{ $alt->title }}</p>
                                        @endif
                                    </li>
                                @empty
                                @endforelse
                            </ol>
                        </div>
                        <div class="row">
                            <audio controls style="width: 350px;">
                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 d-flex justify-content-start mt-1">
                            <br>
                            @include('components.question-actions', [
                                'question' => $question,
                                'questionNumber' => $question_number,
                                'exercise' => $exercise
                            ])
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No questions added.</p>
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
