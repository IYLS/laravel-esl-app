@extends('layouts.app')
@section('main')

<div class="container">
    @include('components.page-header', [
        'title' => 'Fill in the gaps activity',
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
            <div class="card mt-1 mb-1 p-3">
                <div class="row">
                    @if($exercise->subtype == 1)
                        <div class="col-12 col-md-12">
                            <p>{{ $question_number }}. &nbsp;</p>
                            @php
                            $sentence = $question->statement;
                            $sentence_words = explode(' ', $sentence);
                            $words = explode(',', $question->answer);
                            $count = 0;
                            
                            if (count($words) > 0 and $sentence_words > 0)
                            {
                                foreach($sentence_words as $key=>$word) 
                                {
                                    if($word == ";;" or $word == ";;</p>")
                                    {
                                        $sentence_words[$key] = "<strong class='text-primary border-primary ms-2 me-2 d-inline'>".$words[$count]."</strong>";
                                        $count += 1;
                                    }
                                }
                                $result = implode(' ', $sentence_words);
                            }
                            else
                            {
                                $result = "";
                            }

                            @endphp

                            <p style="white-space: pre-wrap;">{!! $result !!}</p>
                        </div>
                        <div class="col-12 col-md-12">
                            <audio controls>
                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                            </audio> 
                        </div>
                        <div class="col-12 col-md-2 mt-2 mt-md-0">
                            @include('components.question-actions', [
                                'question' => $question,
                                'questionNumber' => $question_number,
                                'exercise' => $exercise
                            ])
                        </div>
                    @elseif($exercise->subtype == 2)
                        @php 
                        $result = str_replace(";;", "<strong class='text-primary border-primary ms-2 me-2 d-inline'>" . $question->answer . "</strong>", $question->statement);
                        @endphp
                        <div class="col-12 col-md-10 d-flex">
                            <p>{{ $question_number }}. &nbsp;</p>

                            {!! $result !!}
                        </div>
                        <div class="col-12 col-md-2 mt-5 mt-md-0">
                            @include('components.question-actions', [
                                'question' => $question,
                                'questionNumber' => $question_number,
                                'exercise' => $exercise
                            ])
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No questions added.</p>
            </div>
        @endforelse
        @include('components.question-list-actions', ['exercise' => $exercise])
    </div>

    @include('feedback.show')

    <div class="d-flex justify-content-center">
        <a class="btn btn-primary m-1" href="{{ route('exercises.index', [$exercise->section->unit_id]) }}">Done</a>
    </div>
</div>

@include('modals.questions.add')
@include('modals.questions.set_positions', ["modal_id" => "questions_positions_modal", "questions" => $exercise->questions])

@endsection
