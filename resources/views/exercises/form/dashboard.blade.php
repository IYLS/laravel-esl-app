@include('layouts.tracking.tracking_complete')
<form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="form_form_{{ $e->id }}">
    @csrf
    @foreach($e->questions->sortBy('position') as $question)
        <div class="border rounded p-4 mb-2">
            <h6>{{ $loop->index + 1 . ". " }} {{ $question->correct_answer }}</h6>
            @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
            <table class="table table-bordered">
                <thead>
                    <th>
                        <p class="text-center">{{ $question->heading_title }}</p>
                    </th>
                    <th>
                        <p class="text-center">{{ $question->statement }}</p>
                    </th>
                    @isset($question->answer)
                    <th>
                        <p class="text-center">{{ $question->answer }}</p>
                    </th>
                    @endisset
                </thead>
                <tbody>
                    @foreach($question->alternatives as $alt)
                        @if(isset($question->answer))
                            {{-- DOUBLE COLUMN --}}    
                            <input type="text" name="columns" value="2" hidden>
                            <tr>
                                <td>
                                    <div>
                                        {!! "<p class='d-inline text-center ps-3' name='alt-{{ $question->id }}' id='{{ $alt->id }}'>" . $alt->title . "</p>"  !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check d-flex justify-content-center align-items-center">
                                        <input 
                                            class="form-check-input answer-{{ $question->id}}" 
        
                                            @if(isset($question->exclusive_responses) and $question->exclusive_responses)
                                                type="radio"
                                                name="answers[{{ $question->id}}][0]"
                                            @else
                                                type="checkbox"
                                                name="answers[{{ $question->id}}][0][{{ $alt->id }}]" 
                                            @endif
        
                                            value="{{ $question->statement . ": " . $alt->title}}" 
                                            id="answer-{{ $question->id}} "
                                        >
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check d-flex justify-content-center align-items-center">
                                        <input 
                                            class="form-check-input answer-{{ $question->id}}" 
                                                                                
                                            @if(isset($question->exclusive_responses) and $question->exclusive_responses)
                                                type="radio"
                                                name="answers[{{ $question->id}}][1]"
                                            @else
                                                type="checkbox"
                                                name="answers[{{ $question->id}}][1][{{ $alt->id }}]" 
                                            @endif


                                            value="{{ $question->answer . ": " . $alt->title}}" 
                                            id="answer-{{ $question->id}}"
                                        >
                                    </div>
                                </td>
                            </tr>
                        @else
                            {{-- SINGLE COLUMN --}}
                            <input type="text" name="columns" value="1" hidden>
                            <tr>
                                <td>
                                    <div>
                                        {!! "<p class='d-inline text-center ps-3' name='alt-{{ $question->id }}' id='{{ $alt->id }}'>" . $alt->title . "</p>"  !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check d-flex justify-content-center align-items-center">
                                        <input 
                                            class="form-check-input answer-{{ $question->id}}"
        
                                            @if(isset($question->exclusive_responses) and $question->exclusive_response)
                                                type="radio"
                                                name="answers[{{ $question->id}}][0]"
                                            @else
                                                type="checkbox"
                                                name="answers[{{ $question->id}}][0][{{ $alt->id }}]"
                                            @endif
        
                                            value="{{ $question->statement . ": " . $alt->title}}"
                                            id="answer-{{ $question->id}} "
                                        >
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
        <br>
    @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>