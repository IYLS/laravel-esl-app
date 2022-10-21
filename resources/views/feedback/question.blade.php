@if(isset($feedbacks))
    <div class="m-1 p-1 border rounded feedback question-feedback" id="question-feedback-container-{{ $question->id }}" hidden>
        <p class="p-3 text-success" id="question-{{ $question->id }}-feedback-correct" hidden>✅ Correct</p>
        <p class="p-3 text-danger" id="question-{{ $question->id }}-feedback-wrong" hidden>❌ Wrong</p>

        {{-- Show on Check if correct response --}}
        @if($feedbacks->where('feedback_type_id', 2)->first() != null)
            <p class="show-on-correct-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 2)->first()->message  }}</p>
        @endif

        @if($feedbacks->where('feedback_type_id', 5) != null)
            @foreach($feedbacks->where('feedback_type_id', 5) as $exp)
                <p class="show-on-incorrect-{{ $question->id }}" id="{{ $question->alternatives[$loop->index]->title }}-explainatory" hidden>{{ $exp->message }}</p>
                @php $count = count($feedbacks->where('feedback_type_id', 5)); @endphp 

                @if($loop->index == $count-1)
                    <p class="show-on-incorrect-{{ $question->id }}" id="{{ $question->alternatives[$count]->title }}-explainatory" hidden>{{ $exp->message }}</p>
                @endif
            @endforeach
        @endif

        @if($feedbacks->where('feedback_type_id', 6)->first() != null)
            <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
        @endif

        @if($feedbacks->where('feedback_type_id', 7)->first() != null)
            <p class="show-on-incorrect-{{ $question->id }}">{{ $feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
        @endif

        @if($feedbacks->where('feedback_type_id', 3)->first() != null)
            <audio controls class="col-12" class="show-on-incorrect-{{ $question->id }}">
                <source src="{{ asset('esl/public/storage/files/'.$feedbacks->where('feedback_type_id', 3)->first()->audio_name) }}" type="audio/mpeg">
            </audio>
        @endif
    
    </div>
@endif