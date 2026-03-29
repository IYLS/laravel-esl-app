@forelse($e->questions->sortBy('position') as $question)
    <h6>{{ $loop->index + 1 . ". " }}</h6>
    <h4>{{ $question->correct_answer }}</h4>
    <table class="table table-bordered">
        <thead>
            <th>{!! $question->statement !!}</th>
            <th>{{ $question->answer }}</th>
        </thead>
        <tbody>
            @for ($x = 0; $x <= $question->image_name; $x++)
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Answer here" name="answer-{{ $question->id }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Answer here" name="answer-{{ $question->id }}">
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
@empty
    <div>
        <p class="text-secondary">Empty</p>
    </div>
@endforelse
<br>