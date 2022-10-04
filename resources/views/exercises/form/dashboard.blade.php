@foreach($e->questions as $question)
<div class="border rounded p-4">
    <h6>{{ $loop->index + 1 . ". " }} - {{ $question->correct_answer }}</h6>
    @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
    <table class="table table-bordered">
        <thead>
            <th>
                <p class="text-center">Statemenets</p>
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
                        <input class="form-check-input" type="checkbox" value="" name="first-col-check-{{ $question->id }}">
                    </div>
                </td>
                @isset($question->answer)
                <td>
                    <div class="form-check d-flex justify-content-center align-items-center">
                        <input class="form-check-input" type="checkbox" value="" name="second-col-check-{{ $question->id }}">
                    </div>
                </td>
                @endisset
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach