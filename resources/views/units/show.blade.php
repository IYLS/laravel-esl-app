@extends('layouts.app')
@section('main')

<div class="container d-flex justify-content-end">
    <a href="{{ route('units.index') }}" class="btn btn-link">Go back</a>
</div>
<div class="mt-2 mb-2 container">
    <div class="p-3 mt-2 border shadow rounded">
        <h3>Unit details</h3>
        <form enctype="multipart/form-data" action="{{ route('units.update', $unit) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table" id="create_unit_table">
                <tbody>
                    <tr>
                        <td>
                            <h6>Title:</h6>
                            <input id="title" name="title" class="form-control" type="text" value="{{ $unit->title }}" disabled>
                        </td>
                        <td>
                            <h6>Author:</h6>
                            <input id="author" name="author" class="form-control" type="text" value="{{ $unit->author }}" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6>Description:</h6>
                            <textarea id="description" name="description" class="mce-editor"> {!! $unit->description !!} </textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row mb-2">
                <div class="d-flex align-items-center">
                    <h4>Help options</h4>
                    <a class="btn btn-primary btn-sm ms-3" data-bs-toggle="collapse" href="#collapsableHelpOptions" role="button" aria-expanded="false" aria-controls="collapsableHelpOptions">
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                </div>
            </div>
            <div class="collapse mt-2 mb-2" id="collapsableHelpOptions">
                <div class="card card-body mt-1">
                    <div class="row mb-2">
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Listening Tips:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->listening_tips_enabled) checked @endif  name="listening_tips_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="listening_tips" name="listening_tips" class="mce-editor">{!! $unit->listening_tips !!}</textarea>
                        </div>
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Cultural Notes:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->cultural_notes_enabled) checked @endif  name="cultural_notes_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="cultural_notes" name="cultural_notes" class="mce-editor">{!! $unit->cultural_notes !!}</textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Transcript:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->transcript_enabled) checked @endif  name="transcript_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="transcript" name="transcript" class="mce-editor">{!! $unit->transcript !!}</textarea>
                        </div>
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Glossary:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->glossary_enabled) checked @endif  name="glossary_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="glossary" name="glossary" class="mce-editor">{!! $unit->glossary !!}</textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Translation:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->translation_enabled) checked @endif  name="translation_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="translation" name="translation" class="mce-editor">{!! $unit->translation !!}</textarea>
                        </div>
                        <div class="col-12 col-md-6 mt-1 mt-md-0">
                            <div class="d-flex justify-content-between">
                                <h6>Dictionary:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @if($unit->dictionary_enabled) checked @endif  name="dictionary_enabled" value="true" id="flexCheckDefault" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                      Enabled
                                    </label>
                                </div>
                            </div>
                            <textarea id="dictionary" name="dictionary" class="mce-editor">{!! $unit->dictionary !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-4">
                <h4>Video</h4>
                <div class="row">
                    <div class="col-10">
                        <p>Current video file:  <strong>@if($unit->video_name != "") {{ $unit->video_name }} @else no video file found for this unit. @endif</strong></p>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-sm" type="button" onclick="document.getElementById('video-picker-container').hidden = false;" id="replace_video_button" disabled>Replace</button>
                    </div>
                </div>
                <div class="mb-3" id="video-picker-container" hidden>
                    <label for="video" class="form-label">Select new video file: </label>
                    <input class="form-control" type="file" name="video" id="video" accept="video/*" value="{{ asset('/esl/public/storage/files/'.$unit->video_name) }}">
                </div>
                <div class="row ms-1 me-1">
                    <input name="video_copyright" id="video_copyright" type="text" class="form-control" placeholder="Video copyright info" value="{{ $unit->video_copyright }}" disabled>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <a class="btn btn-success" onClick="enableFields()">Edit</a>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a class="btn btn-secondary mt-1" href="{{ route('units.index') }}">Cancel</a>
                </div>
                <div>
                    <a class="btn btn-info mt-1" href="{{ route('sections.index', $unit->id) }}">Sections</a>
                    <a class="btn btn-info mt-1" href="{{ route('glossed_words.index', $unit->id) }}">Glossed Words</a>
                    <a class="btn btn-info mt-1" href="{{ route('keywords.index', $unit->id) }}">Keywords</a>
                    <a class="btn btn-info mt-1" href="{{ route('exercises.index', $unit->id) }}">Exercises</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var textarea_elements = document.getElementsByClassName('mce-editor');
    $(document).ready(function() {
        $('.mce-editor').each(function(i) {
            tinymce.get(textarea_elements[i].id).mode.set("readonly");
        })
    });

    function enableFields() {
        var input_elements = document.getElementsByTagName('input');
        for (i = 0; i < input_elements.length; i++) {
            input_elements[i].disabled = false;
        }

        var select_elements = document.getElementsByTagName('select');
        for (i = 0; i < select_elements.length; i++) {
            select_elements[i].disabled = false;
        }

        var textarea_elements = document.getElementsByClassName('mce-editor');
        for (i = 0; i < textarea_elements.length; i++) {
            console.log(tinymce.get(textarea_elements[i].id));
            tinymce.get(textarea_elements[i].id).mode.set("design");
        }
        
        var replaceButton = document.getElementById('replace_video_button');
        replaceButton.disabled = false;
    }
</script>

@endsection