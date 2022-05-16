@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New unit</h3>
        <form action="{{ route('units.store') }}" method="POST">
        @csrf
        <table class="table table-striped" id="create_unit_table">
                <tbody>
                    <tr>
                        <td>Title</td>
                        <td>
                            <input id="title" name="title" class="form-control" type="text" placeholder="Type an Title for the new unit">
                        </td>
                    </tr>
                    <tr>
                        <td>Author</td>
                        <td>
                            <input id="author" name="author" class="form-control" type="text" placeholder="Type the author's name for ththise new unit">
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea id="description" name="description" class="form-control" type="text" placeholder="Write a description for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Listening Tips</td>
                        <td>
                            <textarea id="listening_tips" name="listening_tips" type="text" class="form-control" placeholder="Write the listening tips for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Cultural Notes</td>
                        <td>
                            <textarea id="cultural_notes" name="cultural_notes" type="text" class="form-control" placeholder="Write the cultural notes for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Technology Notes</td>
                        <td>
                            <textarea id="technology_notes" name="technology_notes" type="text" class="form-control" placeholder="Write the technology notes for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Biology Notes</td>
                        <td>
                            <textarea id="biology_notes" name="biology_notes" type="text" class="form-control" placeholder="Write the biology notes for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Transcript</td>
                        <td>
                            <textarea id="transcript" name="transcript" type="text" class="form-control" placeholder="Write the transcript for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Glossary</td>
                        <td>
                            <textarea id="glossary" name="glossary" type="text" class="form-control" placeholder="Write the glossary for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Translation</td>
                        <td>
                            <textarea id="translation" name="translation" type="text" class="form-control" placeholder="Write the translation for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Dictionary</td>
                        <td>
                            <textarea id="dictionary" name="dictionary" type="text" class="form-control" placeholder="Write the dictionary for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Video URL</td>
                        <td>
                            <input id="video_url" name="video_url" type="text" class="form-control" placeholder="Write the video url for this new unit">
                        </td>
                    </tr>
                    <tr>
                        <td>Proficiency Level</td>
                        <td>
                            <select id="proficiency_level" name="proficiency_level" class="form-select">
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>
                            <select id="group" name="group" class="form-select">
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Keywords</td>
                        <td>
                            <a class="btn btn-primary" onclick="addRows()">Add keyword</a>
                        </td>
                    </tr>
                </tbody>
        </table>
        <div>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
    </form>
    </div>
</div>

<script>
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

    function removeKeyword(rowNumber) {
        var table = document.getElementById('create_unit_table');
        table.deleteRow(rowNumber);
    }
</script>

@endsection