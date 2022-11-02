<div class="tab-pane fade show active" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="container">
        <h4>{{ $e->title }}</h4>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->instructions) {!! $e->instructions !!} @endisset
        @isset($e->translated_instructions) <p>{!! $e->translated_instructions !!}</p> @endisset
        @include('layouts.tracking_complete')
        <form enctype="multipart/form-data" action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'open_ended');" method="POST" id="open_ended_form_{{ $e->id }}">
            @csrf
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
            @include('layouts.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
        </form>
    </div>
</div>