{{--  PREDICTING --}}
<h5>{{ $e->instructions }}</h5>
@foreach($e->questions as $question)
    @php
        $statements = explode(";", $question->statement); 
    @endphp
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <ol type="I" class="mb-3">
            @foreach($statements as $s) 
                <li>{{ $s }}</li> 
            @endforeach
        </ol>
        <ol type="a">
            @foreach($question->alternatives as $a)
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question-{{ $question->id }}" id="{{ $a->id }}" value="{{ $a->title }}">
                        <label class="form-check-label">{{ $a->title }}</label>
                    </div>
                </li>
            @endforeach
        </ol>
        @include('feedback.question', ['feedbacks' => $question->feedbacks])
    </div>
@endforeach