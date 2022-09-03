<ol type="1">
    @foreach($e->questions as $question)
    <div class="border rounded p-3 mt-3 mb-3 shadow">
        <li>{{ $question->statement }}</li>
        <br>
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
        <br>
    </div>
    @endforeach
</ol>