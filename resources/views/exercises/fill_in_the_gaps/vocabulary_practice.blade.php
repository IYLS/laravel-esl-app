<div class="border rounded p-4">
    <h5>Available words</h5>
    <div class="d-flex">
        <ul class="list-group list-group-horizontal">
            @php 
                $words = array();
                $questions = $e->questions;
                foreach($questions as $q)
                {
                    array_push($words, $q->answer);
                }

                shuffle($words);
            @endphp
            @foreach($words as $word)
                <li class="list-group-item clickable" onclick="strikeWord(this)">{{ $word }}</li>
            @endforeach
        </ul>
    </div>
    <div class="mt-4 mb-2">
        <ol type="1">
            @foreach($e->questions as $question)
                @php
                    $statement = $question->statement;
                    $statement_split = explode(";;", $statement);
                @endphp
                <li>
                    <p>{{ $statement_split[0] }} <input class="mt-1 mb-1 me-1 ms-1" type="text"" style="height: 24px; border-radius: 4px; border: 0.5px solid #ccc; padding: 8px;"> {{ $statement_split[1] }} </p>
                    @include('feedback.question')
                </li>
            @endforeach
        </ol>
    </div>
    @include('feedback.exercise')

    <button class="btn btn-sm btn-primary" onclick="showFeedback()">
        Check
    </button>
</div>