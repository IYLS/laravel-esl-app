@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 col-md-10 p-5 bg-light mt-2 border shadow rounded">
        <h3>Unit details</h3>
        <form enctype="multipart/form-data" action="{{ route('units.update', $unit->id) }}" method="POST">
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
                    <td>
                        <h6>Description:</h6>
                        <textarea id="description" name="description" class="form-control" type="text" rows="6" disabled>{{ $unit->description }}</textarea>
                    </td>
                </tr>

                <tr><td><h4>Help options</h4></td></tr>
                <tr>
                    <td>
                        <h6>Listening Tips:</h6>
                        <textarea id="listening_tips" name="listening_tips" type="text" class="form-control" rows="6" disabled>{{ $unit->listening_tips }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->listening_tips_enabled) checked @endif onclick="switchIsEnabled(this)" name="listening_tips_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>
                    </td>
                    <td>
                        <h6>Cultural Notes:</h6>
                        <textarea id="cultural_notes" name="cultural_notes" type="text" class="form-control" rows="6" disabled>{{ $unit->cultural_notes }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->cultural_notes_enabled) checked @endif onclick="switchIsEnabled(this)" name="cultural_notes_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h6>Transcript:</h6>
                        <textarea id="transcript" name="transcript" type="text" class="form-control" rows="6" disabled>{{ $unit->transcript }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->transcript_enabled) checked @endif onclick="switchIsEnabled(this)" name="transcript_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>                        
                    </td>
                    <td>
                        <h6>Glossary:</h6>
                        <textarea id="glossary" name="glossary" type="text" class="form-control" rows="6" disabled>{{ $unit->glossary }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->glossary_enabled) checked @endif onclick="switchIsEnabled(this)" name="glossary_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h6>Translation:</h6>
                        <textarea id="translation" name="translation" type="text" class="form-control" rows="6" disabled>{{ $unit->translation }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->translation_enabled) checked @endif onclick="switchIsEnabled(this)" name="translation_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>
                    </td>
                    <td>
                        <h6>Dictionary:</h6>
                        <textarea id="dictionary" name="dictionary" type="text" class="form-control" rows="6" disabled>{{ $unit->dictionary }}</textarea>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if($unit->dictionary_enabled) checked @endif onclick="switchIsEnabled(this)" name="dictionary_enabled" value="false" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Enabled
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h6>Video</h6>
                        <div class="mb-3">
                            <label for="video" class="form-label">Select unit video</label>
                            <input class="form-control" type="file" name="video" id="video" accept="video/*" value="{{ asset('/storage/files/'.$unit->video_name) }}">
                        </div>
                    </td>
                </tr>
                <tr>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn btn-success" onClick="enableFields()">Edit</a>
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-secondary" href="{{ route('units.index') }}">Cancel</a>
            </div>
            <div>
                <a class="btn btn-info" href="{{ route('keywords.index', $unit->id) }}">Keywords</a>
                <a class="btn btn-info" href="{{ route('exercises.index', $unit->id) }}">Exercises</a>
            </div>
        </div>
    </form>
    </div>
</div>

<script>
    function enableFields() {
        var input_elements = document.getElementsByTagName('input');
        var select_elements = document.getElementsByTagName('select');
        var textarea_elements = document.getElementsByTagName('textarea');

        for (i = 0; i < input_elements.length; i++) {
            input_elements[i].disabled = false;
        }

        for (i = 0; i < select_elements.length; i++) {
            select_elements[i].disabled = false;
        }

        for (i = 0; i < textarea_elements.length; i++) {
            textarea_elements[i].disabled = false;
        }
    }

    function switchIsEnabled(item) {
        if (item.value == "false") {
            console.log(`${item.name} is ${item.value}`);
            item.value = "true";
        } else {
            if (item.value == "true") {
                console.log(`${item.name} is ${item.value}`);
                item.value = "false";
            }
        }
    }
</script>

@endsection