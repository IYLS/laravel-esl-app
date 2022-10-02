<div class="border rounded p-4">
    <h5>Available words</h5>
    <div class="">
        <ul class="list-group row list-group-horizontal">
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
                <li class="border col-12 col-lg-2 list-group-item clickable" onclick="strikeWord(this)">{{ $word }}</li>
            @endforeach
        </ul>
    </div>
    <div class="mt-4 pt-2 pb-2 mb-2">
        <h5 class="text-center">Statements</h5>
        <ol type="1">
            @foreach($e->questions as $question)
                @php
                    $statement = $question->statement;
                    $statement_split = explode(";;", $statement);
                @endphp
                <li class="row">
                    <p class="col-1 col-lg-1">{{ $loop->index + 1 . ". " }}&nbsp;</p>
                    <p class="col-10 col-lg-4">{{ $statement_split[0] }}</p>
                    &nbsp;
                    <input class="col-10 col-lg-2 border rounded" style="height: 24px;" type="text">
                    &nbsp;
                    <p class="col-12 col-lg-4">{{ $statement_split[1] }}</p>
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