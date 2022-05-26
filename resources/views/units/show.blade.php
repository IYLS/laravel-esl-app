@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 col-md-10 p-5 bg-light mt-2 border shadow rounded">
        <h3>Unit details</h3>
        <form action="{{ route('units.update', $unit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table_stripped" id="create_unit_table">
            <tbody>
                <tr>
                    <td>Title:</td>
                    <td>
                        <input id="title" name="title" class="form-control" type="text" value="{{ $unit->title }}" disabled>
                    </td>
                    <td>Author:</td>
                    <td>
                        <input id="author" name="author" class="form-control" type="text" value="{{ $unit->author }}" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea id="description" name="description" class="form-control" type="text" rows="6" disabled>{{ $unit->description }}</textarea>
                    </td>
                    <td>Listening Tips:</td>
                    <td>
                        <textarea id="listening_tips" name="listening_tips" type="text" class="form-control" rows="6" disabled>{{ $unit->listening_tips }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Cultural Notes:</td>
                    <td>
                        <textarea id="cultural_notes" name="cultural_notes" type="text" class="form-control" rows="6" disabled>{{ $unit->cultural_notes }}</textarea>
                    </td>
                    <td>Technology Notes:</td>
                    <td>
                        <textarea id="technology_notes" name="technology_notes" type="text" class="form-control" rows="6" disabled>{{ $unit->technology_notes }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Biology Notes:</td>
                    <td>
                        <textarea id="biology_notes" name="biology_notes" type="text" class="form-control" rows="6" disabled>{{ $unit->biology_notes }}</textarea>
                    </td>
                    <td>Transcript:</td>
                    <td>
                        <textarea id="transcript" name="transcript" type="text" class="form-control" rows="6" disabled>{{ $unit->transcript }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Glossary:</td>
                    <td>
                        <textarea id="glossary" name="glossary" type="text" class="form-control" rows="6" disabled>{{ $unit->glossary }}</textarea>
                    </td>
                    <td>Translation:</td>
                    <td>
                        <textarea id="translation" name="translation" type="text" class="form-control" rows="6" disabled>{{ $unit->translation }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Dictionary:</td>
                    <td>
                        <textarea id="dictionary" name="dictionary" type="text" class="form-control" rows="6" disabled>{{ $unit->dictionary }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Video URL:</td>
                    <td>
                        <input id="video_url" name="video_url" type="text" class="form-control" value="{{ $unit->video_url }}" disabled>
                    </td>
                    <td>Proficiency Level:</td>
                    <td>
                        <select id="proficiency_level" name="proficiency_level" class="form-select" disabled>
                            @foreach($levels as $level)
                            <option value="{{ $level->id }}" @if($level->id == $unit->proficiency_level_id) selected @endif>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Group:</td>
                    <td>
                        <select id="group" name="group" class="form-select" disabled>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if($group->id == $unit->group_id) selected @endif>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td>Keywords:</td>
                </tr>
                @for ($i = 0; $i < count($keywords); $i++)
                <tr>
                    <td>Keyword {{ $i+1 }}</td>
                    <td>
                        <input name='keyword_name_${keyword_id}' type='text' class='form-control' placeholder="Insert Keyword {{ $i }} name" value="{{ $keywords[$i]->keyword }}">
                    </td>
                    <td>Description</td>
                    <td>
                        <div class="input-group">
                            <input name="keyword_description_{{ $i }}" type='text' class='form-control' placeholder="Insert Keyword {{ $i }} description" value="{{ $keywords[$i]->description }}">
                            <span class="input-group-btn">
                                <a class="btn btn-danger" onclick="removeKeyword(${rowCount})"><i class="fa fa-trash"></i></a>
                            </span>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div>
            <a class="btn btn-secondary" onClick="enableFields()">Edit</a>
            <button class="btn btn-danger">Delete</button>
            <button class="btn btn-primary" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('units.index') }}">Cancel</a>
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

    function removeKeyword(rowNumber) {
        var table = document.getElementById('create_unit_table');
        table.deleteRow(rowNumber);
    }

    function countKeywords() {
        const inputFields = document.getElementsByTagName('input');
        var array = []; 

        for (var i=0; i <= inputFields.length-1; i++) {
            if (inputFields[i].name.includes('keyword_name')) {
                console.log(inputFields[i]);
                array.push(inputFields[i]);
            }
        }

        console.log(array.length);
        return array.length;
    }

    function addRows(){ 
        var table = document.getElementById('create_unit_table');
        var rowCount = table.rows.length;
        var cellCount = table.rows[0].cells.length; 

        var newRow = table.insertRow(rowCount);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);

        const previousKeywordsCount = countKeywords();
        const keyword_id = previousKeywordsCount;

        cell1.innerHTML = `<input name='keyword_name_${keyword_id}' type='text' class='form-control' placeholder='Insert Keyword ${keyword_id} name'>`
        cell2.innerHTML = `<div class="input-group">
                                <input name='keyword_description_${keyword_id}' type='text' class='form-control' placeholder='Insert Keyword ${keyword_id} description'>
                                <span class="input-group-btn">
                                    <a class="btn btn-danger" onclick="removeKeyword(${rowCount})"><i class="fa fa-trash"></i></a>
                                </span>
                            </div>
        `
    }
</script>

@endsection