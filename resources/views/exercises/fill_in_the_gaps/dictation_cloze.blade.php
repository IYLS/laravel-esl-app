@include('layouts.tracking.tracking_complete')
<form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'fill_in_the_gaps');" method="POST" id="fill_in_the_gaps_form_{{ $e->id }}">
    @csrf
    @foreach($e->questions->sortBy('position') as $question)
        <div class="border rounded p-4">
            <p>{{ $loop->index + 1 }}. &nbsp;</p>
            <div class="row mt-2 mb-2">
                <audio controls class="col-12">
                    <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
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
    
    {{-- Feedback del ejercicio: Knowledge of correct response (imagen) después de 3 intentos --}}
    @php
        $attempts_count = \App\Models\Tracking::where('exercise_id', $e->id)->where('user_id', $user->id)->count();
        $knowledge_feedback = $e->feedbacks->where('feedback_type_id', 7)->where('exercise_id', $e->id)->whereNull('question_id')->first();
    @endphp
    
    @if($knowledge_feedback && $knowledge_feedback->image_name && $attempts_count >= 3)
        <div class="border rounded p-4 mt-3 mb-3" id="dictation-cloze-knowledge-feedback-{{ $e->id }}">
            <h5 class="mb-3">📝 Respuestas correctas</h5>
            <div class="text-center">
                <img src="{{ asset('storage/files/'.$knowledge_feedback->image_name) }}" class="img-fluid" alt="Respuestas correctas" style="max-width: 100%; height: auto;">
            </div>
        </div>
    @elseif($knowledge_feedback && $knowledge_feedback->image_name)
        <div class="border rounded p-4 mt-3 mb-3" id="dictation-cloze-knowledge-feedback-{{ $e->id }}" style="display: none;">
            <h5 class="mb-3">📝 Respuestas correctas</h5>
            <div class="text-center">
                <img src="{{ asset('storage/files/'.$knowledge_feedback->image_name) }}" class="img-fluid" alt="Respuestas correctas" style="max-width: 100%; height: auto;">
            </div>
        </div>
    @endif
    
    @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>
