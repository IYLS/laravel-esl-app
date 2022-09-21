{{--  PREDICTING --}}
<div class="row m-3">
    <img src="{{ asset('storage/files/'.$e->image_name) }}" class="img-fluid col-8" alt="img">
</div>
<br>
<h5>{{ $e->instructions }}</h5>
<br>
@foreach($e->questions as $question)
    @php $statements = explode(";", $question->statement); @endphp
        <div class="border rounded p-4 mt-3 mb-3 shadow">

        <ol type="I">
            @foreach($statements as $s) 
            <li>
                {{ $s }}
            </li> 
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
        @include('feedback.question')
    </div>
@endforeach

@include('feedback.exercise')

<div class="m-2 mt-4">
    <button class="btn btn-primary btn-sm" onclick="showFeedback({{ $e->id }})">Check</button>
</div>