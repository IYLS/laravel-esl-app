@if(isset($feedbacks))
    <div class="m-1 p-1 border rounded feedback question-feedback" id="question-feedback-container-{{ $question->id }}" hidden>
        <div class="row">
            <p class="p-3 text-success" id="question-{{ $question->id }}-feedback-correct" hidden>✅ Correct</p>
            <p class="p-3 text-danger" id="question-{{ $question->id }}-feedback-wrong" hidden>❌ Wrong</p>
        </div>

        <ul class="nav nav-tabs" id="questionFeedbackTabs" role="tablist">

            @if($feedbacks->where('feedback_type_id', 6)->first() != null)
                {{-- Directive --}}
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" id="directive-{{ $question->id }}-tab" data-bs-toggle="tab" data-bs-target="#directive-{{ $question->id }}" role="tab" aria-controls="directive-{{ $question->id }}" onclick="show('directive')">🧭</button>
                </li>
            @endif

            @if($feedbacks->where('feedback_type_id', 5) != null)
                {{-- Explainatory --}}
                <li class="nav-item show-on-incorrect-{{ $question->id }}" role="presentation">
                    <button type="button" class="nav-link" id="explainatory-{{ $question->id }}-tab" data-bs-toggle="tab" data-bs-target="#explainatory-{{ $question->id }}" role="tab" aria-controls="explainatory-{{ $question->id }}" onclick="show('explainatory')">❓</button>
                </li>
            @endif

            @if($feedbacks->where('feedback_type_id', 7)->first() != null)
                {{-- Knowledge of correct response --}}
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" id="knowledge-of-correct-response-{{ $question->id }}-tab" data-bs-toggle="tab" data-bs-target="#knowledge-of-correct-response-{{ $question->id }}" role="tab" aria-controls="knowledge-of-correct-response-{{ $question->id }}" onclick="show('knowledge-of-correct-response')">✅</button>
                </li>
            @endif

            @if($feedbacks->where('feedback_type_id', 3)->first() != null)
                {{-- Elaborative --}}
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" id="elaborative-{{ $question->id }}-tab" data-bs-toggle="tab" data-bs-target="#elaborative-{{ $question->id }}" role="tab" aria-controls="elaborative-{{ $question->id }}" onclick="show('elaborative')">🔈</button>
                </li>
            @endif
        </ul>

        <div class="tab-content" id="questionFeedbackTabsContent">
            <div class="tab-pane p-3 fade show active" id="directive-{{ $question->id }}" role="tabpanel" aria-labelledby="directive-{{ $question->id }}-tab">
                {{-- Directive --}}
                @if($feedbacks->where('feedback_type_id', 6)->first() != null)
                    <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
                @endif
            </div>

            <div class="tab-pane p-3 fade" id="explainatory-{{ $question->id }}" role="tabpanel" aria-labelledby="explainatory-{{ $question->id }}-tab">
                {{-- Explainatory --}}
                @if($feedbacks->where('feedback_type_id', 5) != null)
                    @foreach($feedbacks->where('feedback_type_id', 5) as $exp)
                        <p class="show-on-incorrect-{{ $question->id }}" id="{{ $question->alternatives[$loop->index]->title }}-explainatory">{{ $exp->message }}</p>
                        @php $count = count($feedbacks->where('feedback_type_id', 5)); @endphp 

                        @if($loop->index == $count-1)
                            <p class="show-on-incorrect-{{ $question->id }}" id="{{ $question->alternatives[$count]->title }}-explainatory">{{ $exp->message }}</p>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="tab-pane p-3 fade" id="knowledge-of-correct-response-{{ $question->id }}" role="tabpanel" aria-labelledby="knowledge-of-correct-response-{{ $question->id }}-tab">
                {{-- Knowledge of correct response --}}
                @if($feedbacks->where('feedback_type_id', 7)->first() != null)
                    <div class="mt-2">
                        <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
                    </div>
                @endif
            </div>

            <div class="tab-pane p-3 fade" id="elaborative-{{ $question->id }}" role="tabpanel" aria-labelledby="elaborative-{{ $question->id }}-tab">
                {{-- Elaborative --}}
                @if($feedbacks->where('feedback_type_id', 3)->first() != null)  
                    <div class="mt-2">
                        <audio id="elaborative-feedback" controls class="show-on-incorrect-{{ $question->id }}">
                            <source src="{{ asset('esl/public/storage/files/'.$feedbacks->where('feedback_type_id', 3)->first()->audio_name) }}" type="audio/mpeg">
                        </audio>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endif