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
        <nav class="p-2">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#pre-listening" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pre listening</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#while-listening" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">While listening</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#post-listening" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Post listening</button>
            </div>
        </nav>

        <div class="tab-content p-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="pre-listening" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Meet the characters!</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Predicting</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">What do you hear?</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Vocabulary activation</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Vocabulary practice</button>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"></div>
                    
                    </div>
                </div>            
            </div>

            <div class="tab-pane fade" id="while-listening" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Evaluating statement</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Multiple choice</button>
                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Dictation cloze</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="post-listening" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Multiple choioce</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Personal response</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"></div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
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