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
        @forelse($excercise->questions as $question)
            <div class="card mt-1 mb-1 p-4">
                <div class="row">
                    <div class="col-10 d-flex">
                        <p>{{ $loop->index + 1 }}. &nbsp;</p>
                        <p class="text-primary"><strong>{{ ucfirst($question->statement) }}</strong></p>:
                        <p>&nbsp;{{ $question->answer }}</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <br>
                        <form action="{{ route('questions.destroy', [$excercise->id, $question->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-sm m-1" type="submit">Delete</a>
                            <button class="btn btn-warning btn-sm m-1">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No items added.</p>
            </div>
        @endforelse
        <div>
            <button type="button" id="addQuestionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add question</button>
        </div>
    </div>

    @include('feedback.show')

    <div class="d-flex justify-content-center">
        <a class="btn btn-secondary m-1" href="{{ route('excercises.index', [$excercise->section->unit_id]) }}">Save</a>
        <a class="btn btn-secondary m-1" href="{{ route('excercises.index', [$excercise->section->unit_id]) }}">Cancel</a>
    </div>
</div>

@include('excercises.modals.question_modal')

@endsection