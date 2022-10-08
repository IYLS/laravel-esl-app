@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-12 col-md-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New unit</h3>
        <form enctype="multipart/form-data" action="{{ route('units.store') }}" method="POST">
        @csrf
        <table class="table" id="create_unit_table">
                <tbody>
                    <tr><td colspan="3"><h5>Details</h5></td></tr>
                    <tr>
                        <td>Title</td>
                        <td colspan="2">
                            <input id="title" name="title" class="form-control" type="text" placeholder="Type an Title for the new unit" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Author</td>
                        <td colspan="2">
                            <input id="author" name="author" class="form-control" type="text" placeholder="Type the author's name for ththise new unit" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td colspan="2">
                            <textarea id="description" name="description" class="form-control" type="text" placeholder="Write a description for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr><td colspan="3"><h5>Help options</h5></td></tr>
                    <tr>
                        <td>
                            <p>Listening tips</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="listening_tips_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Enabled
                                </label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="listening_tips" name="listening_tips" type="text" class="form-control" placeholder="Write the listening tips for this new unit"></textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <p>Cultural Notes</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="cultural_notes_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Enabled
                                </label>
                            </div>
                        </td>
                        <td colspan="2">
                            <textarea id="cultural_notes" name="cultural_notes" type="text" class="form-control" placeholder="Write the cultural notes for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Transcript</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="transcript_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                Enabled
                                </label>
                            </div>
                        </td>
                        <td>
                            <textarea id="transcript" name="transcript" type="text" class="form-control" placeholder="Write the transcript for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Glossary</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="glossary_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Enabled
                                </label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="glossary" name="glossary" type="text" class="form-control" placeholder="Write the glossary for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Translation</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="translation_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Enabled
                                </label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="translation" name="translation" type="text" class="form-control" placeholder="Write the translation for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dictionary</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onclick="switchIsEnabled(this)" name="dictionary_enabled" value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Enabled
                                </label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="dictionary" name="dictionary" type="text" class="form-control" placeholder="Write the dictionary for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr><td colspan="3"><h5>Unit video</h5></td></tr>
                    <tr>
                        <td colspan="2">
                            <div class="mb-3">
                                <label for="video" class="form-label">Select unit video</label>
                                <input class="form-control" type="file" name="video" id="video" accept="video/*">
                            </div>
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
    function addKeyword(){ 
        var table = document.getElementById('create_unit_table');
        console.log(table.rows.length);
        var rowCount = table.rows.length;
        var cellCount = table.rows[0].cells.length; 

        var newRow = table.insertRow(rowCount);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);

        const previousKeywordsCount = countKeywords();
        const keyword_id = previousKeywordsCount;

        cell1.innerHTML = `<input name='keyword_name_${keyword_id}' type='text' class='form-control' placeholder='Enter keyword name'>`
        cell2.innerHTML = `<div class="input-group">
                                <input name='keyword_description_${keyword_id}' type='text' class='form-control' placeholder='Enter keyword description'>
                                <span class="input-group-btn">
                                    <a class="btn btn-danger" onclick="removeKeyword(this)"><i class="mdi mdi-delete"></i></a>
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

    function removeKeyword(element) {
        const row = element.parentNode.parentNode.parentNode.parentNode;
        document.getElementById("create_unit_table").deleteRow(row.rowIndex);
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