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
            <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" title="YouTube video" allowfullscreen></iframe>
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
            <div class="tab-pane fade show active" id="pre-listening" role="tabpanel" aria-labelledby="pre-listening-tab">

                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($pre_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)
                                <button class="nav-link" id="{{ $e->type . $e->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $e->type . $e->id }}" type="button" role="tab" aria-controls="{{ $e->type . $e->id }}" aria-selected="false">{{ $e->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($pre_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)
                            @if($e->type == 'drag_and_drop')
                            <div class="tab-pane fade" id="{{ $e->type . $e->id }}" role="tabpanel" aria-labelledby="{{ $e->type . $e->id }}-tab">

                                {{--  aqui va el ejercicio en si --}}
                                @foreach($e->questions as $question)
                                    <li>Question  {{ $loop->index }} </li>
                                    <p>{{ $question->concept }}</p>
                                    <p>{{ $question->description }}</p>

                                @endforeach
                            
                            </div>
                            @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                  
            </div>

            <div class="tab-pane fade" id="while-listening" role="tabpanel" aria-labelledby="while-listening-tab">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($while_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $e)
                            <button class="nav-link" id="{{ $a->type . $a->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $a->type . $a->id }}" type="button" role="tab" aria-controls="{{ $a->type . $a->id }}" aria-selected="false">{{ $a->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($while_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $a)
                                <div class="tab-pane fade" id="{{ $a->type . $a->id }}" role="tabpanel" aria-labelledby="{{ $a->type . $a->id }}-tab">{{ $a->title }}</div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="post-listening" role="tabpanel" aria-labelledby="post-listening-tab">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($post_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $d)
                                <button class="nav-link" id="{{ $d->type . $d->id }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $d->type . $d->id }}" type="button" role="tab" aria-controls="{{ $d->type . $d->id }}" aria-selected="false">{{ $d->title }}</button>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($while_listening_excercises as $excercise_type)
                            @foreach($excercise_type as $d)
                                <div class="tab-pane fade" id="{{ $d->type . $d->id }}" role="tabpanel" aria-labelledby="{{ $d->type . $d->id }}-tab">{{ $d->title }}</div>
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

@endsection