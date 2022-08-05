@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Add Drag and drop excercise</h2>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity Details</h4>
        {{-- <form>
            <div>
                <label for="title">Title: </label>
                <input class="form-control" type="text" placeholder="Enter activity title">
            </div>
            <br>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input name="description" id="description" class="form-control" type="text" placeholder="Enter activity description">
            </div>
        </form> --}}
        <h5>Title: {{ $excercise->title }}</h5>
        <p>Description: {{ $excercise->description }}</p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity items</h4>        
        @forelse($questions as $question)
            <div class="card mt-1 mb-1 p-1">
                <div class="row">
                    <div class="col-10">
                        <ul>
                            <li>
                                <p>Concept: {{ $question->concept }}</p>
                            </li>
                            <li>
                                <p>Matching description: {{ $question->description }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-2 d-flex flex-column">
                        <div><a href="#">Eliminar</a></div>
                        <div><a href="#">Modificar</a></div>
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
        <button type="button" class="btn btn-success m-1">Save</button>
        <button type="button" class="btn btn-secondary m-1">Cancel</button>
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
                <form action="{{ route('questions.drag_and_drop.store', [$unit_id, $section, $excercise->id]) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Type word/concept">
                    <br>
                    <input id="description" name="description" type="text" class="form-control" placeholder="Type the matching word/description">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection