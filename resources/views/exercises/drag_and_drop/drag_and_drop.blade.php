<div class="tab-pane fade" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
    <div class="">
        <h4>{{ $e->title }}</h4>
        <p class="text-secondary">{{ $e->description }}</p>
        @isset($e->extra_info) <p class="text-info"><i class="mdi mdi-information-outline text-info"></i> &nbsp; {{ $e->extra_info }}</p> @endisset
        @php
            $words = array();
            $definitions = array();

            foreach($e->questions as $question)
            {
                array_push($words, $question->statement);
                array_push($definitions, $question->answer);
            }

            shuffle($words);
            shuffle($definitions);

            $components = array_combine($words, $definitions);
        @endphp
        <div class="row pt-2 pb-2">
            @include('partials.tracking_complete')
            @php 
                $subtype = $e->subtype != null ? $e->subtype : 1;
            @endphp
            <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="drag_and_drop_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ $e->id }}, 'drag_and_drop')">
                @csrf
                @foreach($e->questions as $question)
                    <div class="col-5 col-lg-2 mt-1">
                        <div ondrop="drop(event)" style="height:30px; width: 140px;" id="word-origin-{{ $question->statement }}" ondragover="allowDrop(event)">
                            <div class="border pe-2 ps-2 text-primary" id="word-{{ $question->statement }}" ondragstart="drag(event)" draggable="true" style="display: inline-block; border-style: dashed !important; height:30px;">
                                {{ $question->statement }}
                            </div>
                        </div>
                    </div>
                    <div class="col-7 col-lg-10 row mt-1">
                        <div class="col-12 col-lg-4 border" style="height:30px; width: 140px;" id="word-destination-{{ $components[$question->statement] }}" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div class="col-12 col-lg-8" id="word-definition-{{ $components[$question->statement] }}">{{ $components[$question->statement] }}</div>
                    </div>
                    @if($e->subtype != '99' && $e->subtype != '991')
                        @include('feedback.question', ['feedbacks' => isset($question->feedbacks) ? $question->feedbacks : null])
                    @endif
                @endforeach

                @include('partials.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
            </form>
        </div>
    </div>
</div>