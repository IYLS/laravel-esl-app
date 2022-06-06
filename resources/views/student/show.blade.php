@extends('layouts.app')
@section('main')

<div class="p-4 row w-100 h-100">

    <h3 class="p-2">{{ $unit->title }}</h3>

    <div class="row">
        <div class="col-4">
            <p class="text-secondary"><small>Keywords:</small></p>
            <a href="#" class="btn btn-link m-1">Listening tips</a>
            <a href="#" class="btn btn-link m-1">Cultural notes</a>
            <a href="#" class="btn btn-link m-1">Transcript</a>
            <a href="#" class="btn btn-link m-1">Glossary</a>
            <a href="#" class="btn btn-link m-1">Translation</a>
            <a href="#" class="btn btn-link m-1">Online dictionary</a>
        </div>
        <div class="col-8">
            <p class="text-secondary"><small>Help options:</small></p>
            <a href="#" class="btn btn-link m-1">Listening tips</a>
            <a href="#" class="btn btn-link m-1">Cultural notes</a>
            <a href="#" class="btn btn-link m-1">Transcript</a>
            <a href="#" class="btn btn-link m-1">Glossary</a>
            <a href="#" class="btn btn-link m-1">Translation</a>
            <a href="#" class="btn btn-link m-1">Online dictionary</a>
            <a href="#" class="btn btn-link m-1">Google search</a>
            <a href="#" class="btn btn-link m-1">Pronunciation aids</a>
        </div>
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
                        <form action="">
                            <input type="text" placeholder="1">
                            <input type="text" placeholder="2">
                            <input type="text" placeholder="3">
                            <input type="text" placeholder="4">
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <form action="">
                            <input type="text" placeholder="5">
                            <input type="text" placeholder="6">
                            <input type="text" placeholder="7">
                            <input type="text" placeholder="8">
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"></div>
                    
                    </div>
                </div>            
            </div>

            <div class="tab-pane fade" id="while-listening" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
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
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <form action="">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"></div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <form action="">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                                <input type="text">
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                    </div>
                </div>
            </div>
        </div>          
    </div>

</div>

@endsection