@include('layouts.tracking_complete')
<form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="form_form_{{ $e->id }}">
    @csrf
    @foreach($e->questions as $question)
        <div class="border rounded p-4">
            <h6>{{ $loop->index + 1 . ". " }} - {{ $question->correct_answer }}</h6>
            @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
            <table class="table table-bordered">
                <thead>
                    <th>
                        <p class="text-center">Statements</p>
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
                    <tr>
                        <td>
                            <div class="text-center">
                                {!! "<p class='d-inline text-center'>" .$loop->index + 1 . "</p>. <p class='d-inline text-center' name='alt-{{ $question->id }}' id='{{ $alt->id }}'>" . $alt->title . "</p>"  !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input 
                                    class="form-check-input answer-{{ $question->id}}" 

                                    @if(isset($question->exclusive_responses))
                                        @if($question->exclusive_responses)
                                            type="radio"
                                            name="answers[{{ $question->id}}][0]" 
                                        @elseif(!$question->exclusive_responses)
                                            type="checkbox"
                                            name="answers[{{ $question->id}}][0][{{ $alt->id }}]" 
                                        @endif
                                    @else
                                        type="checkbox"
                                        name="answers[{{ $question->id}}][0][{{ $alt->id }}]" 
                                    @endif

                                    value="true" 
                                    id="answer-{{ $question->id}} "
                                >
                            </div>
                        </td>
                        @isset($question->answer)
                        <td>
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input 
                                class="form-check-input answer-{{ $question->id}}" 
                                                                    
                                @if(isset($question->exclusive_responses))
                                    @if($question->exclusive_responses)
                                        type="radio"
                                        name="answers[{{ $question->id}}][1]"
                                    @elseif(!$question->exclusive_responses)
                                        type="checkbox"
                                        name="answers[{{ $question->id}}][1][{{ $alt->id }}]"
                                    @endif
                                @else
                                    type="checkbox"
                                    name="answers[{{ $question->id}}][1][{{ $alt->id }}]" 
                                @endif

                                value="true" 
                                id="answer-{{ $question->id}}">
                            </div>
                        </td>
                        @endisset
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
        <br>
    @include('layouts.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>