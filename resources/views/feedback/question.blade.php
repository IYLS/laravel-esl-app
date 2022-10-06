@isset($e->feedbacks)

    <div class="m-1 p-1 border border-success feedback question-feedback" hidden>
        @if(in_array('1', $feedback_content["ids"]))
            <p class="text-secondary">💡 Short Message A</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 1)->first()->message }}</p>
        @endif

        @if(in_array('2', $feedback_content["ids"]))
            <p class="text-secondary">💡 Short Message B</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 2)->first()->message }}</p>
        @endif

        @if(in_array('3', $feedback_content["ids"]))
            <p class="text-secondary">💡 Elaborative</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 3)->first()->message }}</p>
        @endif

        @if(in_array('4', $feedback_content["ids"]))
            <p class="text-secondary">💡 Short Message C</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 4)->first()->message }}</p>
        @endif

        @if(in_array('5', $feedback_content["ids"]))
            <p class="text-secondary">💡 Explainatory</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 5)->first()->message }}</p>
        @endif

        @if(in_array('6', $feedback_content["ids"]))
            <p class="text-secondary">💡 Directive</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 6)->first()->message }}</p>
        @endif

        @if(in_array('7', $feedback_content["ids"]))
            <p class="text-secondary">💡  Knowledge of correct response</p>
            <p>{{ $e->feedbacks->where('feedback_type_id', 7)->first()->message }}</p>
        @endif
{{--         
        <div class="row">
            <audio controls class="col-12">
                <source src="{{ asset('esl/public/storage/files/'.$feedback->audio_name) }}" type="audio/mpeg">
            </audio>
        </div> --}}
    </div>

@endisset