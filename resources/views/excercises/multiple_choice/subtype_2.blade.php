<ol type="1">
                                                    
    @foreach($e->questions as $question)
    <div class="border rounded p-3 mt-3 mb-3 shadow">
        @php 
        $statement = str_replace(";;","_______", $question->statement)
        @endphp
        <li>{{ $statement }}</li>
        <br>
        <audio controls class="col-6">
            <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
        </audio> 
        <div class="mt-2">
            <ol type="a">
                @foreach($question->alternatives as $a)
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . $a->id }}" value="option1" >
                        <label class="form-check-label" for="{{ $question->id . $a->id }}">{{ $a->title }}</label>
                    </div>    
                </li>
                @endforeach
            </ol>
        </div>

        <br>
    </div>
    @endforeach
    
</ol>