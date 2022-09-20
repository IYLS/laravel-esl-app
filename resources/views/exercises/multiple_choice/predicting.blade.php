{{--  PREDICTING --}}
<div class="row m-3">
    <img src="{{ asset('storage/files/'.$e->image_name) }}" class="img-fluid col-8" alt="img">
</div>
<br>
<h5>{{ $e->instructions }}</h5>
<br>

@foreach($e->questions as $question)

    @php $statements = explode(";", $question->statement); @endphp

    <ol type="I">
        @foreach($statements as $s) 
        <li>{{ $s }}</li> 
        @endforeach
    </ol>
    <br>
    <ol type="a">
        @foreach($question->alternatives as $a)
        <li>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="{{ $question->id . $a->id }}" value="{{ $a->correct_alt }}">
                <label class="form-check-label" for="exampleRadios1">{{ $a->title }}</label>
            </div>    
        </li>
        @endforeach
    </ol>
@endforeach

<div class="m-1 feedback" hidden>
    <h5 class="text-success"><strong>Feedback:</strong></h5>
    <p class="text-success">{{ "Good job!" }} &#9989;</p>
</div>

<div class="m-2 mt-4">
    <button class="btn btn-primary btn-sm" onclick="showFeedback()">Check</button>
</div>