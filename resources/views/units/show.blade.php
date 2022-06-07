@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 col-md-10 p-5 bg-light mt-2 border shadow rounded">
        <h3>Unit details</h3>
        <form action="{{ route('units.update', $unit->id) }}" method="POST">
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
                    </td>
                    <td>
                        <h6>Cultural Notes:</h6>
                        <textarea id="cultural_notes" name="cultural_notes" type="text" class="form-control" rows="6" disabled>{{ $unit->cultural_notes }}</textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h6>Transcript:</h6>
                        <textarea id="transcript" name="transcript" type="text" class="form-control" rows="6" disabled>{{ $unit->transcript }}</textarea>
                    </td>
                    <td>
                        <h6>Glossary:</h6>
                        <textarea id="glossary" name="glossary" type="text" class="form-control" rows="6" disabled>{{ $unit->glossary }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h6>Translation:</h6>
                        <textarea id="translation" name="translation" type="text" class="form-control" rows="6" disabled>{{ $unit->translation }}</textarea>
                    </td>
                    <td>
                        <h6>Dictionary:</h6>
                        <textarea id="dictionary" name="dictionary" type="text" class="form-control" rows="6" disabled>{{ $unit->dictionary }}</textarea>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td>
                        <h6>Group:</h6>
                        <select id="group" name="group" class="form-select" disabled>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if($group->id == $unit->group_id) selected @endif>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn btn-success" onClick="enableFields()">Edit</a>
                <button class="btn btn-danger">Delete</button>
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-secondary" href="{{ route('units.index') }}">Cancel</a>
            </div>
            <div>
                <a class="btn btn-info" href="{{ route('keywords.index', $unit->id) }}">Keywords</a>
                <a class="btn btn-info" href="{{ route('excercises.index', $unit->id) }}">Exercises</a>
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
</script>

@endsection