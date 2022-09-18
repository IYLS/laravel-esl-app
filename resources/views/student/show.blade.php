@extends('layouts.app')
@section('main')

<style>
    .strikable { text-decoration: line-through }
    .modal-backdrop { opacity: 0 !important }
</style>

<div class="p-4 row w-100 h-100">
    <h5 class="pl-2">{{ $unit->title }}</h5>
    <div class="row">
        <div class="col-4">
            <small class="text-secondary">Keywords:</small>
            @foreach($keywords as $keyword)
            @php $modal_id = "keywordModal"; @endphp
            <button type="button" id="{{ $modal_id . "Button" }}" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">{{ $keyword->keyword }}</button>
            @include('modals.keyword', ['modal_id' => $modal_id, 'description' => $keyword->description, 'modal_title' => $keyword->keyword])
            @endforeach
        </div>
        <div class="col-8">
            @include('excercises.help_options', ['unit' => $unit])
        </div>
    </div>
    <div class="row" id="keywords_content">
        <div class="col-4" id="keywords_detail"></div>
        <div class="col-8" id="help_option_detail"></div>
    </div>

    {{-- Video section --}}
    <div class="col-4">
        <div class="ratio ratio-16x9 mt-3">
            <iframe src="{{ asset('/storage/files') . "/" . $unit->video_name }}" title="Video" allowfullscreen controls></iframe>
        </div>
    </div>

    {{-- Exercises and content section --}}
    <div class="col-8 bg-light p-3 rounded shadow">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($unit->sections as $section)
                <li class="nav-item" role="presentation">
                    @if($loop->index == 0)
                        <button class="nav-link active" id="{{ $section->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $section->name}}" type="button" role="tab" aria-controls="{{ $section->name }}" aria-selected="true">{{ $section->name }}</button>
                    @else
                        <button class="nav-link" id="{{ $section->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $section->name}}" type="button" role="tab" aria-controls="{{ $section->name }}" aria-selected="false">{{ $section->name }}</button>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($unit->sections as $section)
                @if($loop->index == 0)
                    <div class="tab-pane fade show active m-2" id="{{ $section->name }}" role="tabpanel" aria-labelledby="{{ $section->name }}-tab">
                @else
                    <div class="tab-pane fade" id="{{ $section->name }}" role="tabpanel" aria-labelledby="{{ $section->name }}-tab">
                @endif
                <div class="d-flex align-items-start mt-2">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($section->excercises as $e)
                            <button class="nav-link" id="{{ $e->excerciseType->underscore_name . $e->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $e->excerciseType->underscore_name . $e->id }}" type="button" role="tab" aria-controls="{{ $e->excerciseType->underscore_name . $e->id }}" aria-selected="false">{{ $e->title }}</button>
                        @endforeach
                    </div>
                    <div class="tab-content container" id="v-pills-tabContent">
                        @foreach($section->excercises as $e)
                            @switch($e->excerciseType->underscore_name)

                            @case('drag_and_drop')
                                @include('excercises.drag_and_drop.dds', ['e' => $e])
                                @break
                            @case('open_ended')
                                @include('excercises.open_ended.subtype', ['e' => $e])
                                @break
                            @case('voice_recognition')
                                @include('excercises.voice_recognition.asd', ['e' => $e])
                                @break
                            @case('multiple_choice')
                                <div class="tab-pane fade" id="{{ $e->excerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->excerciseType->underscore_name . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>

                                        {{-- Subtype 1 = Predicting --}}
                                        @if($e->subtype == 1)
                                            @include('excercises.multiple_choice.predicting', ['e' => $e])

                                        {{-- Subtype 2 = What do you hear? --}}
                                        @elseif($e->subtype == 2)
                                            @include('excercises.multiple_choice.what_do_you_hear', ['e' => $e])

                                        {{-- Subtype 3 = Evaluating statements --}}
                                        @elseif($e->subtype == 3)
                                            @include('excercises.multiple_choice.evaluating_statements', ['e' => $e])

                                        {{-- Subtype 4 = Multiple Choice --}}
                                        @elseif($e->subtype == 4)
                                            @include('excercises.multiple_choice.multiple_choice', ['e' => $e])
                                        @endif
                                    </div>
                                </div>
                                @break
                            @case('fill_in_the_gaps')
                            <div class="tab-pane fade" id="{{ $e->excerciseType->underscore_name . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->excerciseType->underscore_name . $e->id }}-tab">
                                <div class="container">
                                    <h4>{{ $e->title }}</h4>
                                    <p class="text-secondary">{{ $e->description }}</p>
                                    
                                    @if($e->subtype == 1) 
                                        
                                        @foreach($e->questions as $question)
                                        <div class="border rounded p-3">
                                            <p>Item {{ $loop->index + 1 }}</p>
                                            <div class="row mt-2 mb-2">
                                                <audio controls class="col-12">
                                                    <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                                </audio> 
                                            </div>
                                            <div class="mt-4 mb-4">
                                                @php
                                                $gaps_count = substr_count($question->statement, ";;");
                                                $strips = explode(";;", $question->statement);
                                                @endphp

                                                @foreach($strips as $strip)
                                                {{ $strip }} @if($loop->index < $gaps_count) <input class="mt-1 mb-1 me-1 ms-1" type="text"" style="height: 24px; border-radius: 4px; border: 0.5px solid #ccc; padding: 8px;"> @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach

                                    @elseif($e->subtype == 2)
                                        
                                        <div class="p-4">
                                            <h5>Available words</h5>
                                            <div class="d-flex">
                                                <ul class="list-group list-group-horizontal">
                                                    @foreach($e->questions as $question)
                                                        <li class="matching_word list-group-item">{{ $question->answer }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mt-4 mb-2">
                                                <ol type="1">
                                                    @foreach($e->questions as $question)
                                                        @php
                                                            $statement = $question->statement;
                                                            $statement_split = explode(";;", $statement);
                                                        @endphp
                                                        <li>
                                                            <p>{{ $statement_split[0] }} <input class="mt-1 mb-1 me-1 ms-1" type="text"" style="height: 24px; border-radius: 4px; border: 0.5px solid #ccc; padding: 8px;"> {{ $statement_split[1] }} </p>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>

                                    @endif
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

{{-- Drag and drop --}}
<script>
    function allowDrop(ev) {
      ev.preventDefault();
    }
    
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }
    
    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      ev.target.appendChild(document.getElementById(data));
    }

    const boxes = document.querySelectorAll('.matching_word');
    for (const box of boxes) {
        box.addEventListener('click', function handleClick() {
            if('strikable' in box.classList) {
                box.classList.remove('strikable');
            } else {
                box.classList.add('strikable');
            }
        });
    }

    function showFeedback() {
        const feedbackElements = document.getElementsByClassName('feedback');
        for (const element of feedbackElements){
            element.hidden = false;
        };
    }
</script>

@endsection