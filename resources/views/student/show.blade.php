@extends('layouts.app')
@section('main')

@section('title', 'Student Module')

<div class="p-4 row w-100 h-100 col-12 student-module">
    <h5 class="pl-2">{{ $unit->title }}</h5>
    <div class="row sticky-top p-1" id="sticky-bar" style="background-color: white;">
        <div class="col-12 col-lg-4 col-xl-4">
            @forelse($keywords as $keyword)
                @php $modal_id = "keyword_modal-$keyword->id"; @endphp
                <button type="button" id="{{ $modal_id . "_button" }}" class="mt-1 btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onclick="unstick()">{{ $keyword->keyword }}</button>
                @include('modals.keywords.show', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @empty
                <p class="text-center text-secondary"><small>No keywords added for this unit.</small></p>
            @endforelse
        </div>
        <div class="col-12 col-lg-8 col-xl-8">
            @include('exercises.help_options', ['unit' => $unit])
        </div>
    </div>

    {{-- Video section --}}
    <div class="col-12 col-xl-4">
        @if(isset($unit->video_name) and $unit->video_name != null and $unit->video_name != '')
            <div class="ratio ratio-16x9 mt-3">
                <video title="Video" allowfullscreen controls>
                    <source src="{{ asset('storage/files') . "/" . $unit->video_name }}">
                </video>
            </div>
            @if(isset($unit->video_copyright) and $unit->video_copyright != '') <p class="text-secondary"><small>{{ $unit->video_copyright }}</small></p> @endif
        @else
            <div class="text-center">
                <p class="text-secondary"><small>No video set for this unit.</small></p>
            </div>
        @endif
    </div>

    {{-- Exercises and content section --}}
    <div class="col-12 col-xl-8 bg-light mt-2 p-3 rounded shadow overflow-auto" id="top_student_area" style="max-height: calc(100vh - 120px);">
        <ul class="nav nav-tabs" id="sectionsTabs" role="tablist">
            @foreach($unit->sections->sortBy('position') as $section)
                @php 
                    $index = $loop->index + 1;
                    if(isset($section_first_exercise_id)) {
                        $section_first_exercise_id = $section->exercises->first()->id;
                    } else {
                        $section_first_exercise_id = 0;
                    }
                @endphp
                <li class="nav-item" role="presentation">
                    @if($index-1 == 0)
                        <button 
                            class="nav-link section-btn active" 
                            id="{{ $section->underscore_name }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $section->underscore_name}}" 
                            type="button" 
                            role="tab" 
                            aria-controls="{{ $section->underscore_name }}" 
                            aria-selected="true"
                            onclick="setCurrentExercise({{ json_encode($section_first_exercise_id) }}); onExerciseClicked({{ json_encode($section_first_exercise_id) }});"
                        >
                            {{ $index . ". " . $section->name }}
                        </button>
                    @else
                        <button 
                            class="nav-link section-btn" 
                            id="{{ $section->underscore_name }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $section->underscore_name}}" 
                            type="button" 
                            role="tab" 
                            aria-controls="{{ $section->underscore_name }}" 
                            aria-selected="false"
                            onclick="setCurrentExercise({{ json_encode($section_first_exercise_id) }}); onExerciseClicked({{ json_encode($section_first_exercise_id) }});"
                        >
                            {{ $index . ". " . $section->name }}
                        </button>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($unit->sections->sortBy('position') as $section)
                @if($loop->index == 0)
                    <div class="tab-pane fade show section-pane active m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @else
                    <div class="tab-pane fade section-pane m-2" id="{{ $section->underscore_name }}" role="tabpanel" aria-labelledby="{{ $section->underscore_name }}-tab">
                @endif
                <div class="d-flex align-items-start row mt-2">

                    {{-- (Optional) Additional Information --}}
                    @if(isset($section->instructions) and $section->instructions != '')
                    <div class="card pt-1 mb-2 pb-1 d-flex justify-content-center">
                        <p class="text-primary"><span class="material-symbols-outlined text-primary">info</span>&nbsp;{{ $section->instructions }}</p>
                    </div>
                    @endif
                    <div class="nav flex-column mt-2 nav-pills col-12 col-xl-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @forelse($section->exercises->sortBy('position') as $e)
                            @php $index = $loop->index; @endphp
                            <button 
                                class="nav-link exercise-btn @if($e->subtype == 99 || $e->subtype == 991) meta @endif @if($index == 0) active @endif"
                                id="{{ $e->exerciseType->underscore_name . $e->id }}-tab" 
                                data-bs-toggle="pill" 
                                data-bs-target="#{{ $e->exerciseType->underscore_name . $e->id }}" 
                                type="button" 
                                role="tab" 
                                aria-controls="{{ $e->exerciseType->underscore_name . $e->id }}" 
                                @if($index == 0)
                                    aria-selected="true"
                                @else
                                    aria-selected="false"
                                @endif
                                onclick="startTimer(); onExerciseClicked({{ json_encode($e->id) }})">
                                    @if($e->title == '' or $e->title == null) 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="text-end">Activity #{{ $e->id }}</p>
                                                </div>
                                                <div>
                                                    <p>✅</p>
                                                </div>
                                            </div>
                                        @else
                                            Activity #{{ $e->id }}
                                        @endif
                                    @else 
                                        @if(count($completed_exercises) != 0 and in_array($e->id, $completed_exercises)) 
                                            {{ $e->title }} ✅
                                        @else
                                            {{ $e->title }}
                                        @endif
                                    @endif
                            </button>
                        @empty
                            <p class="text-center text-secondary"><small>No exercises added yet.</small></p>    
                        @endforelse
                    </div>
                    <div class="tab-content container-fluid col-12 col-xl-10" id="v-pills-tabContent">
                        @foreach($section->exercises->sortBy('position') as $e)
                            @php
                                $feedback_content = array(
                                    'ids' => [],
                                    'names' => [],
                                    'text_based' => [],
                                );

                                if($e->feedbacks != null)
                                {
                                    foreach($e->feedbacks as $feedback)
                                    {
                                        array_push($feedback_content['ids'], $feedback->feedbackType->id);
                                        array_push($feedback_content['names'], $feedback->feedbackType->name);
                                        array_push($feedback_content['text_based'], $feedback->feedbackType->text_based);
                                    }
                                }
                            @endphp

                            @switch($e->exerciseType->underscore_name)
                            @case('drag_and_drop')
                                @include('exercises.drag_and_drop.drag_and_drop')
                                @break
                            @case('open_ended')
                                <div class="tab-pane exercise-pane fade @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        @include('layouts.tracking.tracking_complete')
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="open_ended_form_{{ $e->id }}" onsubmit="return getResponseData({{ json_encode($e->questions) }}, {{ json_encode($e) }}, 'open_ended')">
                                            @csrf
                                            @if($e->subtype == 1 or $e->subtype == 99)
                                                @include('exercises.open_ended.single_text')
                                            @elseif($e->subtype == 991)
                                                @include('exercises.open_ended.double_text')
                                            @endif
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('voice_recognition')
                                @include('exercises.voice_recognition.asd')
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset
                                        @include('layouts.tracking.tracking_complete')

                                        @if(isset($e->video_name) and $e->video_name != null and $e->video_name != '')
                                            <video title="Video" allowfullscreen controls class="ratio ratio-16x9 mt-3 w-75">
                                                <source src="{{ asset('storage/files') . "/" . $e->video_name }}">
                                            </video>
                                        @endif

                                        @if(isset($e->image_name) and $e->image_name != null and $e->image_name != '')
                                            <div class="row m-3">
                                                <img src="{{ asset('storage/files'. "/" . $e->image_name) }}" class="img-fluid col-12 col-lg-8" alt="img">
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('tracking.store', ["$e->id", "$user->id"]) }}" method="POST" id="multiple_choice_form_{{ $e->id }}">
                                            @csrf
                                            {{-- Subtype 1 = Predicting --}}
                                            @if($e->subtype == 1)
                                                @include('exercises.multiple_choice.predicting')

                                            {{-- Subtype 2 = What do you hear? --}}
                                            @elseif($e->subtype == 2)
                                                @include('exercises.multiple_choice.what_do_you_hear')

                                            {{-- Subtype 3 = Evaluating statements --}}
                                            @elseif($e->subtype == 3)
                                                @include('exercises.multiple_choice.evaluating_statements')

                                            {{-- Subtype 4 = Multiple Choice --}}
                                            @elseif($e->subtype == 4 or $e->subtype == 99)
                                                @include('exercises.multiple_choice.multiple_choice')
                                            @endif
                                            
                                            <br>
                                            @include('layouts.tracking.tracking_buttons', ['tracking' => $e->tracking, 'questions' => $e->questions, 'exercise_id' => $e->id, 'subtype' => $e->subtype])
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{--  Dictation Cloze  --}}
                                        @if($e->subtype == 1) 
                                            @include('exercises.fill_in_the_gaps.dictation_cloze')

                                        {{-- Vocabulary Practice --}}
                                        @elseif($e->subtype == 2)
                                            @include('exercises.fill_in_the_gaps.vocabulary_practice')
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('form')
                                <div class="tab-pane fade exercise-pane @if($loop->index == 0) show active @endif" id="{{ $e->exerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->exerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @isset($e->instructions) <div class="text-dark">{!! $e->instructions !!}</div> @endisset
                                        @isset($e->translated_instructions) <div class="text-secondary">{!! $e->translated_instructions !!}</div> @endisset
                                        @isset($e->extra_info) <p class="text-info"><span class="material-symbols-outlined text-info">info</span> &nbsp; {{ $e->extra_info }}</p> @endisset

                                        {{-- Form --}}
                                        @include('exercises.form.dashboard')
                                        
                                    </div>
                                </div>
                                @break
                                @default
                            @endswitch
                        @endforeach
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- JavaScript modularizado y organizado --}}
<script src="{{ asset('js/student-exercises.js') }}"></script>

<script>
    // Inicializar variables necesarias desde PHP
    window.current_exercise_id = {{ json_encode($first_exercise_id) }};
    
    // Inicializar timer al cargar la página
    if (typeof startTimer === 'function') {
        startTimer();
    }
</script>

{{-- Cargar JavaScript modularizado --}}
<script src="{{ asset('js/student-exercises.js') }}"></script>

<script>
    // Inicializar variables necesarias desde PHP
    window.current_exercise_id = {{ json_encode($first_exercise_id) }};
    
    // Inicializar timer al cargar la página
    if (typeof startTimer === 'function') {
        startTimer();
    }
</script>

@endsection
