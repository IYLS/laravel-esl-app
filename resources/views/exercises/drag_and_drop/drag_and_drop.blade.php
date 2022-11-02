<div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->instructions) {!! $e->instructions !!} @endisset
        @isset($e->translated_instructions) <p>{!! $e->translated_instructions !!}</p> @endisset
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        @php
            $words = array();
            $definitions = array();

            foreach($e->questions->sortBy('position') as $question)
            {
                array_push($words, $question->statement);
                array_push($definitions, $question->answer);
            }

            shuffle($words);
            shuffle($definitions);

            $components = array_combine($words, $definitions);
        @endphp
        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="drag_and_drop_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'drag_and_drop')">
            @csrf
            <div class="row d-flex justify-content-between pt-2 pb-2">
                @include('layouts.tracking_complete')
                @php $subtype = $e->subtype != null ? $e->subtype : 1; @endphp
                @foreach($e->questions->sortBy('position') as $question)
                    <div class="col-6 col-lg-3 mt-1 d-flex justify-content-center border" style="border-style: dashed !important;" ondragover="allowDrop(event)" ondrop="drop(event)">
                        <div style="height:30px; width: 140px;" id="word-origin-{{ $question->statement }}">
                            <div class="border pe-2 ps-2 text-primary" id="word-{{ $question->statement }}" ondragstart="drag(event)" draggable="true" style="display: inline-block; border-style: dashed !important; height:30px;">
                                {{ $question->statement }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-1 col-6 col-lg-9 row">
                        <div class="d-inline col-5 border d-flex align-items-center" style="height:45px; width: 140px;" id="word-destination-{{ $components[$question->statement] }}" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="d-inline col-7" id="word-definition-{{ $components[$question->statement] }}">{{ $components[$question->statement] }}</div>
                    </div>
                    @if($e->subtype != '99' && $e->subtype != '991')
                        @include('feedback.question', ['feedbacks' => isset($question->feedbacks) ? $question->feedbacks : null])
                    @endif
                @endforeach

                @include('layouts.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
            </div>
        </form>
    </div>
</div>