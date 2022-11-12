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
                            <input id="author" name="author" class="form-control" type="text" placeholder="Type the author's name for this new unit" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td colspan="2">
                            <textarea id="description" name="description" class="mce-editor" placeholder="Write a description for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr><td colspan="3"><h5>Help options</h5></td></tr>
                    <tr>
                        <td>
                            <p>Tips</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="listening_tips_enabled" value="true" id="listening_tips_enabled">
                                <label class="form-check-label" for="listening_tips_enabled">Enabled</label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="listening_tips" name="listening_tips" class="mce-editor" placeholder="Write the Tips for this new unit"></textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <p>Cultural Notes</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cultural_notes_enabled" value="true" id="cultural_notes_enabled">
                                <label class="form-check-label" for="cultural_notes_enabled">Enabled</label>
                            </div>
                        </td>
                        <td colspan="2">
                            <textarea id="cultural_notes" name="cultural_notes" class="mce-editor" placeholder="Write the cultural notes for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Transcript</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="transcript_enabled" value="true" id="transcript_enabled">
                                <label class="form-check-label" for="transcript_enabled">Enabled</label>
                            </div>
                        </td>
                        <td>
                            <textarea id="transcript" name="transcript" class="mce-editor" placeholder="Write the transcript for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Glossary</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="glossary_enabled" value="true" id="glossary_enabled">
                                <label class="form-check-label" for="glossary_enabled">Enabled</label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="glossary" name="glossary" class="mce-editor" placeholder="Write the glossary for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Translation</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="translation_enabled" value="true" id="translation_enabled">
                                <label class="form-check-label" for="translation_enabled">Enabled</label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="translation" name="translation" class="mce-editor" placeholder="Write the translation for this new unit"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dictionary</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dictionary_enabled" value="true" id="dictionary_enabled">
                                <label class="form-check-label" for="dictionary_enabled">Enabled</label>
                              </div>
                        </td>
                        <td colspan="2">
                            <textarea id="dictionary" name="dictionary" class="mce-editor" placeholder="Write the dictionary for this new unit"></textarea>
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
                    <tr>
                        <td colspan="2">
                            <div class="mb-2">
                                <label class="form-label">Video Copyright info</label>
                                <input name="video_copyright" id="video_copyright" type="text" class="form-control">
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

@endsection