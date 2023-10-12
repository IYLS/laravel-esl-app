<div class="m-1 ps-1 pe-1 border rounded question-feedback" id="question-feedback-container-{{ $question->id }}" hidden>
    <div class="row">
        <p class="p-3 text-success" id="question-{{ $question->id }}-feedback-correct" hidden>✅</p>
        <p class="p-3 text-danger" id="question-{{ $question->id }}-feedback-wrong" hidden>❌</p>
    </div>

    @php

    $directive = false;
    $explanatory = false;
    $elaborative = false;
    $knowledge = false;

    if($feedbacks->where('feedback_type_id', 3)->first() != null) $elaborative = true;
    if($feedbacks->where('feedback_type_id', 6)->first() != null) $directive = true;
    if($feedbacks->where('feedback_type_id', 7)->first() != null) $knowledge = true;
    if($feedbacks->where('feedback_type_id', 5)->first() != null) $explanatory = true;

    $first = "";
    if($elaborative) {
        $first = "elaborative";
    } else if(!$elaborative and $directive) {
        $first = "directive";
    } else if(!$elaborative and !$directive and $knowledge) {
        $first = "knowledge";
    } else if(!$elaborative and !$directive and !$knowledge and $explanatory) {
        $first = "explanatory";
    }

    @endphp

    @if(isset($feedbacks) and count($feedbacks) != 0)
        <ul class="nav nav-tabs" id="questionFeedbackTabs" role="tablist">

            @if($elaborative)
                {{-- Elaborative --}}
                <li class="nav-item" role="presentation">
                    <button 
                        type="button" 
                        class="nav-link @if($first == 'elaborative') active @endif" 
                        id="elaborative-{{ $question->id }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#elaborative-{{ $question->id }}" 
                        aria-controls="elaborative-{{ $question->id }}"
                        role="tab" 
                        onclick="onFeedbackButtonPressed({{ json_encode($question->id) }}, 'elaborative');"
                    >
                        🔈
                    </button>
                </li>
                
            @endif

            @if($directive)
                {{-- Directive --}}
                <li class="nav-item" role="presentation">
                    <button 
                        type="button" 
                        class="nav-link @if($first == 'directive') active @endif" 
                        id="directive-{{ $question->id }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#directive-{{ $question->id }}"
                        aria-controls="directive-{{ $question->id }}"
                        role="tab" 
                        onclick="onFeedbackButtonPressed({{ json_encode($question->id) }}, 'directive');"
                    >
                        🧭
                    </button>
                </li>
            @endif

            @if($knowledge)
                {{-- Knowledge of correct response --}}
                <li class="nav-item" role="presentation">
                    <button 
                        type="button" 
                        class="nav-link @if($first == 'knowledge') active @endif" 
                        id="knowledge-of-correct-response-{{ $question->id }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#knowledge-of-correct-response-{{ $question->id }}"
                        aria-controls="knowledge-of-correct-response-{{ $question->id }}"
                        role="tab" 
                        onclick="onFeedbackButtonPressed({{ json_encode($question->id) }}, 'knowledge');"
                    >
                        ✅
                    </button>
                </li>
            @endif

            @if($explanatory)
                {{-- Explanatory --}}
                <li class="nav-item show-on-incorrect-{{ $question->id }}" role="presentation">
                    <button 
                        type="button" 
                        class="nav-link @if($first == 'explanatory') active @endif" 
                        id="explanatory-{{ $question->id }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#explanatory-{{ $question->id }}"
                        aria-controls="explanatory-{{ $question->id }}"
                        role="tab"
                        onclick="onFeedbackButtonPressed({{ json_encode($question->id) }}, 'explanatory');"
                    >
                        ❓
                    </button>
                </li>
            @endif

        </ul>

        <div class="tab-content" id="questionFeedbackTabsContent">
            <div class="tab-pane p-3 fade @if($first == 'directive') show active @endif" id="directive-{{ $question->id }}" role="tabpanel" aria-labelledby="directive-{{ $question->id }}-tab">
                {{-- Directive --}}
                @if($feedbacks->where('feedback_type_id', 6)->first() != null)
                    <p class="text-secondary mb-1 mt-1"><small>Directive feedback</small></p>
                    <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
                @endif
            </div>

            <div class="tab-pane p-3 fade @if($first == 'explanatory') show active @endif" id="explanatory-{{ $question->id }}" role="tabpanel" aria-labelledby="explanatory-{{ $question->id }}-tab">
                {{-- Explanatory --}}
                @if($feedbacks->where('feedback_type_id', 5)->first() != null)
                    <p class="text-secondary mb-1 mt-1"><small>Explanatory feedback</small></p>

                    @php 
                        $fb = $feedbacks->where('feedback_type_id', 5);
                        $index = 0;
                    @endphp

                    @foreach($question->alternatives as $alt)
                        @if(!$alt->correct_alt and isset($fb[$index]))
                            <p class="show-on-incorrect-{{ $question->id }}" id="{{ $alt->title }}-explanatory">{{ $fb[$index]->message }}</p>
                            @php $index = $index + 1; @endphp
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="tab-pane p-3 fade @if($first == 'knowledge') show active @endif" id="knowledge-of-correct-response-{{ $question->id }}" role="tabpanel" aria-labelledby="knowledge-of-correct-response-{{ $question->id }}-tab">
                {{-- Knowledge of correct response --}}
                @if($feedbacks->where('feedback_type_id', 7)->first() != null)
                    <div class="mt-2">
                        <p class="text-secondary mb-1 mt-1"><small>Knowledge of correct response feedback</small></p>
                        <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
                    </div>
                @endif
            </div>

            <div class="tab-pane p-3 fade @if($first == 'elaborative') show active @endif" id="elaborative-{{ $question->id }}" role="tabpanel" aria-labelledby="elaborative-{{ $question->id }}-tab">
                {{-- Elaborative --}}
                @if($feedbacks->where('feedback_type_id', 3)->first() != null)  
                    <div class="mt-2">
                        <p class="text-secondary mb-1 mt-1"><small>Elaborative feedback</small></p>
                        <audio id="elaborative-feedback" controls class="show-on-incorrect-{{ $question->id }}">
                            <source src="{{ asset('esl/public/storage/files/'.$feedbacks->where('feedback_type_id', 3)->first()->audio_name) }}" type="audio/mpeg">
                        </audio>
                    </div>
                @endif
            </div>
        </div>

    @endif
</div>

{{-- Feedback interactions --}}
<input type="text" value="0" class="feedback_interactions_count_{{ $e->id }}" id="directive_count_{{ $question->id }}" name="directive[{{ $question->id }}]" hidden>
<input type="text" value="0" class="feedback_interactions_count_{{ $e->id }}" id="elaborative_count_{{ $question->id }}" name="elaborative[{{ $question->id }}]" hidden>
<input type="text" value="0" class="feedback_interactions_count_{{ $e->id }}" id="explanatory_count_{{ $question->id }}" name="explanatory[{{ $question->id }}]" hidden>
<input type="text" value="0" class="feedback_interactions_count_{{ $e->id }}" id="knowledge_count_{{ $question->id }}" name="knowledge[{{ $question->id }}]" hidden>

<script>
    function onFeedbackButtonPressed(question_id, type) {
        var item = document.getElementById(`${type}_count_${question_id}`);
        var new_value = parseInt(item.value) + 1;
        
        item.setAttribute('value', `${new_value}`);
    }
</script>