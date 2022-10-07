<div class="tab-pane fade show active" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        <p class="text-secondary">{{ $e->description }}</p>
        <form action="">
            @forelse($e->questions as $question)
                <h6>{{ $loop->index + 1 . ". " }}</h6>
                <h4>{{ $question->correct_answer }}</h4>
                <table class="table table-bordered">
                    <thead>
                        <th>{{ $question->statement }}</th>
                        <th>{{ $question->answer }}</th>
                    </thead>
                    <tbody>
                        @for ($x = 0; $x <= $question->image_name; $x++)
                        <tr>
                            <td>
                                <input type="text" class="form-control" placeholder="Answer here">
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Answer here">
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
        </form>
    </div>
</div>

<div class="m-2 mt-3">
    <button class="btn btn-sm btn-primary" type="submit">
        Submit
    </button>
</div>