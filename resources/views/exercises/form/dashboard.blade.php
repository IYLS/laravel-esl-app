@include('partials.tracking_complete')
<form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'form');" method="POST" id="form_form_{{ $e->id }}">
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
                            <p class="text-center">
                                {{ $loop->index + 1 . ". " .  $alt->title }}
                            </p>
                        </td>
                        <td>
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input answer-{{ $question->id}}" type="checkbox" value="true" name="first-col-check-{{ $question->id }}">
                            </div>
                        </td>
                        @isset($question->answer)
                        <td>
                            <div class="form-check d-flex justify-content-center align-items-center">
                                <input class="form-check-input answer-{{ $question->id}}" type="checkbox" value="true" name="second-col-check-{{ $question->id }}">
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
    @include('partials.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
</form>