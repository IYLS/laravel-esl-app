{{-- MULTIPLE CHOICE --}}
@foreach($e->questions as $question)
    <div class="border rounded p-4 mt-3 mb-3 shadow">
        <p>{{ $loop->index + 1 . ". "  . $question->statement }}</p>
        <div class="mt-2">
            <ol type="a">
                @foreach($question->alternatives as $a)
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                        <label class="form-check-label" for="{{ $question->id . "true" }}">{{ $a->title }}</label>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        @include('feedback.question')
    </div>
@endforeach

@include('feedback.exercise')

<button class="btn btn-sm btn-primary" onclick="showFeedback()">
    Check
</button>
