@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Voice Recognition activity</h2>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity Details</h4>
        <h5>Title: {{ $excercise->title }}</h5>
        <p>Description: {{ $excercise->description }}</p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity items</h4>        
        @forelse($questions as $question)
            <h5 class="mt-2">Item {{ $loop->index + 1 }}</h5>
            <div class="card mt-1 mb-1 p-1">
                <div class="row">
                    <div class="col-10">
                        <ul>
                            <li>
                                <p>Item title: {{ $question->title }}</p>
                            </li>
                            <li>
                                <p>Audio url: {{ $question->audio_url }}</p>
                            </li>
                            <li>
                                <p>Image url: {{ $question->image_url }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-2 d-flex flex-column">
                        {{-- <a href="{{ route('questions.drag_and_drop.destroy', [$unit_id, $excercise->id, $question->id]) }}">Eliminar</a> --}}
                        {{-- <div><a href="{{ route('excercises.' . $excercise->type . '.create', [$unit_id, $excercise->section_id, $excercise->id]) }}">Modificar</a></div> --}}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No items added.</p>
            </div>
        @endforelse

        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add item</button>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ URL::previous() }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ URL::previous() }}">Cancel</a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModal">New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('questions.voice_recognition.store', [$unit_id, $excercise->section_id, $excercise->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Item title:</label>
                        <input class="form-control" name="title" id="title" type="text" placeholder="Type item's title">
                    </div>
                    <div class="mb-3">
                        <label for="audio" class="form-label">Select audio file</label>
                        <input class="form-control" type="file" name="audio" id="audio">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Select image file</label>
                        <input class="form-control" type="file" name="image" id="image">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection