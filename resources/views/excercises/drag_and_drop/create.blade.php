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
                                <p>Word: {{ $question->statement }}</p>
                            </li>
                            <li>
                                <p>Matching definition: {{ $question->answer }}</p>
                            </li>
                        </ul>
                        <div class="col-2 d-flex justify-content-center">
                            <br>
                            <form action="{{ route('questions.destroy', [$unit_id, $question->excercise->excerciseType->name, $excercise->id, $question->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm m-1" type="submit">Delete</a>
                                <button class="btn btn-warning btn-sm m-1">Edit</button>
                            </form>
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

    <div class="card p-4 m-2">
        <h4>Feedback</h4>        
        <div class="card mt-1 mb-1 p-1">
            <div class="row">
                <div class="col-10">
                    @if(true)
                    <div class="m-3">
                        <p>Type: Elavorative</p>
                    </div>
                    @else

                    @endif
                </div>
            </div>
        </div>

        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add item</button>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ route('excercises.index', [$unit_id]) }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ route('excercises.index', [$unit_id]) }}">Cancel</a>
    </div>
</div>

@include('excercises.question_modal')

@endsection