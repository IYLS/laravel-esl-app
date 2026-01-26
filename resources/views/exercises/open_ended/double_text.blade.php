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

@if($e->subtype == 99 || $e->subtype == 991)
    <div class="mt-3 mb-3">
        <x-forum-link class="btn-sm" />
    </div>
@endif
<br>