@include('layouts.tracking.tracking_complete')
<form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'fill_in_the_gaps');" method="POST" id="fill_in_the_gaps_form_{{ $e->id }}">
    @csrf
    @foreach($e->questions->sortBy('position') as $question)
        <div class="border rounded p-4">
            <p>{{ $loop->index + 1 }}. &nbsp;</p>
            <div class="row mt-2 mb-2">
                <audio controls class="col-12">
                    <source src="{{ asset('esl/public/storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                </audio> 
            </div>
            <div class="mt-4 mb-4">
                @php
                    $gaps_count = substr_count($question->statement, ";;");
                    $words = explode(" ", $question->statement);

                    $final_string = [];
                    foreach($words as $key=>$word) {
                        if($word == ";;") {
                            array_push($final_string, "<input class='mt-1 mb-1 me-1 ms-1 d-inline p-2 border rounded' name='answer-$question->id' type='text' style='font-size:14px; height: 24px;'>");
                        } else {
                            array_push($final_string, $word);
                        }
                    }

                    $statement = implode(' ', $final_string);
                @endphp

                {!! $statement !!}

            </div>
            @include('feedback.question', ['feedbacks' => $question->feedbacks])
        </div>

    @endforeach
    <br>
    @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>