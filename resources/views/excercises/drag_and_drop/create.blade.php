@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Add Drag and drop excercise</h2>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity Details</h4>
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
                                <p>Word: {{ $question->word }}</p>
                            </li>
                            <li>
                                <p>Matching definition: {{ $question->definition }}</p>
                            </li>
                        </ul>
                        <div class="col-2 d-flex justify-content-center">
                            <button class="btn btn-danger btn-sm m-1">Delete</button>
                            <br>
                            <button class="btn btn-warning btn-sm m-1">Edit</button>
                        </div>
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
                <form action="{{ route('questions.drag_and_drop.store', [$unit_id, $excercise->section_id, $excercise->id]) }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Type the word">
                    <br>
                    <input id="definition" name="definition" type="text" class="form-control" placeholder="Type the matching definition">
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