@include('layouts.tracking.tracking_complete')
<div class="border rounded p-4">
    <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="fill_in_the_gaps_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'fill_in_the_gaps')">
        @csrf
        <h5>Available words</h5>
        @php 
            $words = array();
            $questions = $e->questions;
            foreach($questions as $q) array_push($words, $q->answer);

            shuffle($words);
        @endphp
        <div class="container">
            <div class="row">
                @foreach($words as $word)
                    <div class="col pt-2 pb-2 border clickable" onclick="strikeWord(this)">
                        {{ $word }}
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-4 pt-2 pb-2 mb-2">
            <ol type="1">
                @foreach($e->questions->sortBy('position') as $question)
                    @php
                        $statement = $question->statement;
                        $statement_split = explode(";;", $statement);
                    @endphp
                    <li class="mt-2 mb-2">
                        @if(count($statement_split) == 2)
                            <p class="d-inline">{{ $statement_split[0] }}</p>
                            &nbsp;
                            <input class="d-inline border rounded" style="height: 24px;" type="text" name="answer-{{ $question->id }}">
                            &nbsp;
                            <p class="d-inline">{{ $statement_split[1] }}</p>
                        @elseif(count($statement_split) == 1)
                            <p class="d-inline">{{ $statement_split[0] }}</p>
                            &nbsp;
                            <input class="d-inline border rounded" style="height: 24px;" type="text" name="answer-{{ $question->id }}"">
                        @endif

                        @include('feedback.question', ['feedbacks' => $question->feedbacks])
                    </li>
                @endforeach
            </ol>
        </div>
        @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
    </form>
</div>
