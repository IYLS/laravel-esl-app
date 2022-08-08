@extends('layouts.app')
@section('main')

<div class="p-4 row w-100 h-100">
    <h5 class="pl-2">{{ $unit->title }}</h5>
    <div class="row">
        <div class="col-4">
            <small class="text-secondary">Keywords:</small>
            @foreach($keywords as $keyword)
            <a href="#" class="btn btn-primary btn-sm m-1 keyword-btn" onclick="presentKeywordsText(`{{ $keyword->description }}`)">{{ $keyword->keyword }}</a>
            @endforeach
        </div>
        <div class="col-8">
            <small class="text-secondary">Help options: </small>
            @if($unit->listening_tips_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->listening_tips }}`)">Listening tips</a>@endif
            @if($unit->cultural_notes_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->cultural_notes }}`)">Cultural notes</a>@endif
            @if($unit->transcript_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->transcript }}`)">Transcript</a>@endif
            @if($unit->glossary_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->glossary }}`)">Glossary</a>@endif
            @if($unit->translation_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->translation }}`)">Translation</a>@endif
            @if($unit->dictionary_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText(`{{ $unit->dictionary }}`)">Online dictionary</a>@endif
             {{-- @if($unit->listening_tips_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText()">Google search</a>@endif --}}
             {{-- @if($unit->listening_tips_enabled)<a href="#" class="btn btn-primary btn-sm m-1 help-option-btn" onclick="presentHelpOptionsText()">Pronunciation aids</a>@endif --}}
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
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pre-listening-tab" data-bs-toggle="tab" data-bs-target="#pre-listening" type="button" role="tab" aria-controls="pre-listening" aria-selected="true">Pre listening</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="while-listening-tab" data-bs-toggle="tab" data-bs-target="#while-listening" type="button" role="tab" aria-controls="while-listening" aria-selected="false">While listening</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="post-listening-tab" data-bs-toggle="tab" data-bs-target="#post-listening" type="button" role="tab" aria-controls="post-listening" aria-selected="false">Post listening</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active m-2" id="pre-listening" role="tabpanel" aria-labelledby="pre-listening-tab">

                <div class="d-flex align-items-start mt-2">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($pre_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)
                                <button class="nav-link" id="{{ $e->type . $e->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $e->type . $e->id }}" type="button" role="tab" aria-controls="{{ $e->type . $e->id }}" aria-selected="false">{{ $e->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content container" id="v-pills-tabContent">
                        @foreach($pre_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)
                                
                                {{-- Drag and Drop excercise --}}
                                @if($e->type == 'drag_and_drop')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @php
                                        $words = array();
                                        $definitions = array();
                                        @endphp
                                        @foreach($e->questions as $question)
                                            @php 
                                            array_push($words, $question->word);
                                            array_push($definitions, $question->definition);
                                            @endphp
                                        @endforeach
                                        @php
                                            shuffle($words);
                                            shuffle($definitions);
                                        @endphp
                                        <div class="row mt-2 mb-2">
                                            <div class="col-3">
                                                <h5>Words</h5>
                                                <br>
                                                <div class="mt-1 mb-1">
                                                    @foreach($words as $word)
                                                    <div id="div2-{{ $word }}" class="m-1" style="width: 200px; height: 35px;" draggable="true" ondragstart="drag(event)">
                                                        <p>{{ $loop->index + 1 . ". " .$word }}</p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <h5>Definitions</h5>
                                                <br>
                                                @foreach($definitions as $definition)
                                                    <div class="row mt-1 mb-1">
                                                        <div class="border-bottom col-4" id="div1-{{ $definition }}"  style="width: 200; height: 35px;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                                                        <div class="col-8">{{ $definition }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'open_ended')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @forelse($e->questions as $question)
                                        <div class="mb-3">
                                            <p>{{ $loop->index + 1 . ". " . $question->title }}</p>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
                                        </div>
                                        @empty
                                        <div>
                                            <p class="text-secondary">Empty</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'voice_recognition')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        <div class="row">
                                        @foreach($e->questions as $question)
                                        <div class="col-5 mt-1 text-center">
                                            <p>{{ $question->title }}</p>
                                            <img src="{{ asset('storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
                                            <audio controls class="col-6">
                                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                            </audio> 
                                        </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'multiple_choice')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>

                                        {{-- Subtype 1 = Predicting --}}
                                        @if($e->subtype == 1)
                                            <div class="row m-3">
                                                <img src="{{ asset('storage/files/'.$e->image_name) }}" class="img-fluid col-8" alt="img">
                                            </div>
                                            <br>
                                            <p>{{ $e->instructions }}</p>
                                            <br>
                                            
                                            @foreach($e->questions as $question)
                                                @php $statements = explode(";", $question->statement); @endphp

                                                <ol type="I">
                                                    @foreach($statements as $s) 
                                                    <li>{{ $s }}</li> 
                                                    @endforeach
                                                </ol>
                                                <br>
                                                <ol type="a">
                                                    @foreach($question->alternatives as $a)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="exampleRadios" id="{{ $question->id . $a->id }}" value="option1" >
                                                            <label class="form-check-label" for="exampleRadios1">{{ $a->title }}</label>
                                                        </div>    
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            @endforeach
                                            

                                        {{-- Subtype 2 = What do you hear? --}}
                                        @elseif($e->subtype == 2)
                                            <ol type="1">
                                                
                                                @foreach($e->questions as $question)
                                                <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                    @php 
                                                    $statement = str_replace(";;","_______", $question->statement)
                                                    @endphp
                                                    <li>{{ $statement }}</li>
                                                    <br>
                                                    <audio controls class="col-6">
                                                        <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                                    </audio> 
                                                    <div class="mt-2">
                                                        <ol type="a">
                                                            @foreach($question->alternatives as $a)
                                                            <li>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . $a->id }}" value="option1" >
                                                                    <label class="form-check-label" for="{{ $question->id . $a->id }}">{{ $a->title }}</label>
                                                                </div>    
                                                            </li>
                                                            @endforeach
                                                        </ol>
                                                    </div>

                                                    <br>
                                                </div>
                                                @endforeach
                                                
                                            </ol>
                                        {{-- Subtype 3 = Evaluating statements --}}
                                        @elseif($e->subtype == 3)
                                        <ol type="1">
                                                
                                            @foreach($e->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">True</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "false" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "false" }}">False</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "not sure" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "not sure" }}">I'm not sure</label>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                        </ol>

                                        {{-- Subtype 4 = Multiple Choice --}}
                                        @elseif($e->subtype == 4)
                                        <ol type="1">
                                                
                                            @foreach($e->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        @foreach($question->alternatives as $a)
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">{{ $a->title }}</label>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                            
                                        </ol>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'fill_in_the_gaps')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        {{-- Fill-in the gaps --}}
                                    </div>
                                </div>
                                @endif

                            @endforeach
                        @endforeach
                    </div>
                </div>
                  
            </div>

            <div class="tab-pane fade" id="while-listening" role="tabpanel" aria-labelledby="while-listening-tab">
                <div class="d-flex align-items-start mt-2">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($while_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $a)
                            <button class="nav-link" id="{{ $a->type . $a->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $a->type . $a->id }}" type="button" role="tab" aria-controls="{{ $a->type . $a->id }}" aria-selected="false">{{ $a->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($while_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)

                                {{-- Drag and Drop excercise --}}
                                @if($e->type == 'drag_and_drop')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @php
                                        $words = array();
                                        $definitions = array();
                                        @endphp
                                        @foreach($e->questions as $question)
                                            @php 
                                            array_push($words, $question->word);
                                            array_push($definitions, $question->definition);
                                            @endphp
                                        @endforeach
                                        @php
                                            shuffle($words);
                                            shuffle($definitions);
                                        @endphp
                                        <div class="row mt-2 mb-2">
                                            <div class="col-3">
                                                <h5>Words</h5>
                                                <br>
                                                <div class="mt-1 mb-1">
                                                    @foreach($words as $word)
                                                    <div id="div2-{{ $word }}" class="m-1" style="width: 200px; height: 35px;" draggable="true" ondragstart="drag(event)">
                                                        <p>{{ $loop->index + 1 . ". " .$word }}</p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <h5>Definitions</h5>
                                                <br>
                                                @foreach($definitions as $definition)
                                                    <div class="row mt-1 mb-1">
                                                        <div class="border-bottom col-4" id="div1-{{ $definition }}"  style="width: 200; height: 35px;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                                                        <div class="col-8">{{ $definition }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'open_ended')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        @forelse($e->questions as $question)
                                        <div class="mb-3">
                                            <p>{{ $loop->index + 1 . ". " . $question->title }}</p>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
                                        </div>
                                        @empty
                                        <div>
                                            <p class="text-secondary">Empty</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'voice_recognition')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>
                                        <div class="row">
                                        @foreach($e->questions as $question)
                                        <div class="col-5 mt-1 text-center">
                                            <p>{{ $question->title }}</p>
                                            <img src="{{ asset('storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
                                            <audio controls class="col-6">
                                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                            </audio> 
                                        </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'multiple_choice')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $e->title }}</h4>
                                        <p class="text-secondary">{{ $e->description }}</p>

                                        {{-- Subtype 1 = Predicting --}}
                                        @if($e->subtype == 1)
                                            <div class="row m-3">
                                                <img src="{{ asset('storage/files/'.$e->image_name) }}" class="img-fluid col-8" alt="img">
                                            </div>
                                            <br>
                                            <p>{{ $e->instructions }}</p>
                                            <br>
                                            
                                            @foreach($e->questions as $question)
                                                @php $statements = explode(";", $question->statement); @endphp

                                                <ol type="I">
                                                    @foreach($statements as $s) 
                                                    <li>{{ $s }}</li> 
                                                    @endforeach
                                                </ol>
                                                <br>
                                                <ol type="a">
                                                    @foreach($question->alternatives as $a)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="exampleRadios" id="{{ $question->id . $a->id }}" value="option1" >
                                                            <label class="form-check-label" for="exampleRadios1">{{ $a->title }}</label>
                                                        </div>    
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            @endforeach
                                            

                                        {{-- Subtype 2 = What do you hear? --}}
                                        @elseif($e->subtype == 2)
                                            <ol type="1">
                                                
                                                @foreach($e->questions as $question)
                                                <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                    @php 
                                                    $statement = str_replace(";;","_______", $question->statement)
                                                    @endphp
                                                    <li>{{ $statement }}</li>
                                                    <br>
                                                    <audio controls class="col-6">
                                                        <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                                    </audio> 
                                                    <div class="mt-2">
                                                        <ol type="a">
                                                            @foreach($question->alternatives as $a)
                                                            <li>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . $a->id }}" value="option1" >
                                                                    <label class="form-check-label" for="{{ $question->id . $a->id }}">{{ $a->title }}</label>
                                                                </div>    
                                                            </li>
                                                            @endforeach
                                                        </ol>
                                                    </div>

                                                    <br>
                                                </div>
                                                @endforeach
                                                
                                            </ol>
                                        {{-- Subtype 3 = Evaluating statements --}}
                                        @elseif($e->subtype == 3)
                                        <ol type="1">
                                                
                                            @foreach($e->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">True</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "false" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "false" }}">False</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "not sure" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "not sure" }}">I'm not sure</label>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                        </ol>
                                        
                                        {{-- Subtype 4 = Multiple Choice --}}
                                        @elseif($e->subtype == 4)
                                        <ol type="1">
                                                
                                            @foreach($e->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        @foreach($question->alternatives as $a)
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">{{ $a->title }}</label>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                            
                                        </ol>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($e->type == 'fill_in_the_gaps')
                                <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">
                                    <div class="container">
                                        {{-- Fill-in the gaps --}}
                                    </div>
                                </div>
                                @endif
                        @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="post-listening" role="tabpanel" aria-labelledby="post-listening-tab">
                <div class="d-flex align-items-start mt-2">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($post_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $d)
                                <button class="nav-link" id="{{ $d->type . $d->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $d->type . $d->id }}" type="button" role="tab" aria-controls="{{ $d->type . $d->id }}" aria-selected="false">{{ $d->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($post_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $d)

                                {{-- Drag and Drop excercise --}}
                                @if($d->type == 'drag_and_drop')
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $d->title }}</h4>
                                        <p class="text-secondary">{{ $d->description }}</p>
                                        @php
                                        $words = array();
                                        $definitions = array();
                                        @endphp
                                        @foreach($d->questions as $question)
                                            @php 
                                            array_push($words, $question->word);
                                            array_push($definitions, $question->definition);
                                            @endphp
                                        @endforeach
                                        @php
                                            shuffle($words);
                                            shuffle($definitions);
                                        @endphp
                                        <div class="row mt-2 mb-2">
                                            <div class="col-3">
                                                <h5>Words</h5>
                                                <br>
                                                <div class="mt-1 mb-1">
                                                    @foreach($words as $word)
                                                    <div id="div2-{{ $word }}" class="m-1" style="width: 200px; height: 35px;" draggable="true" ondragstart="drag(event)">
                                                        <p>{{ $loop->index + 1 . ". " .$word }}</p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <h5>Definitions</h5>
                                                <br>
                                                @foreach($definitions as $definition)
                                                    <div class="row mt-1 mb-1">
                                                        <div class="border-bottom col-4" id="div1-{{ $definition }}"  style="width: 200; height: 35px;" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                                                        <div class="col-8">{{ $definition }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($d->type == 'open_ended')
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $d->title }}</h4>
                                        <p class="text-secondary">{{ $d->description }}</p>
                                        @forelse($d->questions as $question)
                                        <div class="mb-3">
                                            <p>{{ $loop->index + 1 . ". " . $question->title }}</p>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter the Answer here"></textarea>
                                        </div>
                                        @empty
                                        <div>
                                            <p class="text-secondary">Empty</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                @endif

                                @if($d->type == 'voice_recognition')
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $d->title }}</h4>
                                        <p class="text-secondary">{{ $d->description }}</p>
                                        <div class="row">
                                        @foreach($d->questions as $question)
                                        <div class="col-5 mt-1 text-center">
                                            <p>{{ $question->title }}</p>
                                            <img src="{{ asset('storage/files/'.$question->image_name) }}" class="img-fluid col-6" alt="img">
                                            <audio controls class="col-6">
                                                <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                            </audio> 
                                        </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($d->type == 'multiple_choice')
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">
                                    <div class="container">
                                        <h4>{{ $d->title }}</h4>
                                        <p class="text-secondary">{{ $d->description }}</p>

                                        {{-- Subtype 1 = Predicting --}}
                                        @if($d->subtype == 1)
                                            <div class="row m-3">
                                                <img src="{{ asset('storage/files/'.$d->image_name) }}" class="img-fluid col-8" alt="img">
                                            </div>
                                            <br>
                                            <p>{{ $d->instructions }}</p>
                                            <br>
                                            
                                            @foreach($d->questions as $question)
                                                @php $statements = explode(";", $question->statement); @endphp

                                                <ol type="I">
                                                    @foreach($statements as $s) 
                                                    <li>{{ $s }}</li> 
                                                    @endforeach
                                                </ol>
                                                <br>
                                                <ol type="a">
                                                    @foreach($question->alternatives as $a)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="exampleRadios" id="{{ $question->id . $a->id }}" value="option1" >
                                                            <label class="form-check-label" for="exampleRadios1">{{ $a->title }}</label>
                                                        </div>    
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            @endforeach
                                            

                                        {{-- Subtype 2 = What do you hear? --}}
                                        @elseif($d->subtype == 2)
                                            <ol type="1">
                                                
                                                @foreach($d->questions as $question)
                                                <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                    @php 
                                                    $statement = str_replace(";;","_______", $question->statement)
                                                    @endphp
                                                    <li>{{ $statement }}</li>
                                                    <br>
                                                    <audio controls class="col-6">
                                                        <source src="{{ asset('storage/files/'.$question->audio_name) }}" type="audio/mpeg">
                                                    </audio> 
                                                    <div class="mt-2">
                                                        <ol type="a">
                                                            @foreach($question->alternatives as $a)
                                                            <li>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . $a->id }}" value="option1" >
                                                                    <label class="form-check-label" for="{{ $question->id . $a->id }}">{{ $a->title }}</label>
                                                                </div>    
                                                            </li>
                                                            @endforeach
                                                        </ol>
                                                    </div>

                                                    <br>
                                                </div>
                                                @endforeach
                                                
                                            </ol>
                                        {{-- Subtype 3 = Evaluating statements --}}
                                        @elseif($d->subtype == 3)
                                        <ol type="1">
                                                
                                            @foreach($d->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">True</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "false" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "false" }}">False</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "not sure" }}" value="option1">
                                                                <label class="form-check-label" for="{{ $question->id . "not sure" }}">I'm not sure</label>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                        </ol>
                                        
                                        {{-- Subtype 4 = Multiple Choice --}}
                                        @elseif($d->subtype == 4)
                                        <ol type="1">
                                            
                                            @foreach($d->questions as $question)
                                            <div class="border rounded p-3 mt-3 mb-3 shadow">
                                                <li>{{ $question->statement }}</li>
                                                <br>
                                                <div class="mt-2">
                                                    <ol type="a">
                                                        @foreach($question->alternatives as $a)
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{ $question->id }}" id="{{ $question->id . "true" }}" value="option1" >
                                                                <label class="form-check-label" for="{{ $question->id . "true" }}">{{ $a->title }}</label>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                                <br>
                                            </div>
                                            @endforeach
                                            
                                        </ol>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if($d->type == 'fill_in_the_gaps')
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">
                                    <div class="container">
                                        {{-- Fill-in the gaps --}}
                                    </div>
                                </div>
                                @endif

                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
          </div>
    </div>
</div>


<script>
    function presentKeywordsText(text) {
        var detailBox = document.getElementById("keywords_detail");

        if (detailBox.innerHTML != "") {
            detailBox.removeChild(detailBox.lastChild);
        } else {
            var child = document.createElement('p');
            child.innerHTML = `${text}`;
            detailBox.appendChild(child);
        }
    }

    function presentHelpOptionsText(text) {
        var detailBox = document.getElementById("help_option_detail");

        if (detailBox.innerHTML != "") {
            detailBox.removeChild(detailBox.lastChild);
        } else {
            var child = document.createElement('p');
            child.innerHTML = `${text}`;
            detailBox.appendChild(child);
        }
    }
</script>

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
</script>

@endsection