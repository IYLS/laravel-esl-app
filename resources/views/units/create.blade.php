@extends('layouts.app')
@section('main')

<div class="row d-flex justify-content-center mt-3 mb-3">
    <div class="col-6 p-5 bg-light mt-2 border shadow rounded">
        <h3>New unit</h3>
        <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <table class="table table-striped">
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
                            <textarea id="name" name="name" class="form-control" type="text" placeholder="Write a description for this new unit"></textarea>
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

                </tbody>
        </table>
        <div>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
    </form>
    </div>
</div>

@endsection