@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Open Ended questions activity</h2>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity Details</h4>
        <h5>Title: {{ $excercise->title }}</h5>
        <p>Description: {{ $excercise->description }}</p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>        
        @forelse($excercise->questions as $question)
            <div class="card mt-1 mb-1 p-4">
                <div class="row">
                    <div class="col-10">
                        <p>Question:</p>
                        <ul>
                            <li>
                                <p>{{ $question->statement }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <br>
                        <form action="{{ route('questions.destroy', [$excercise->id, $question->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-sm m-1" type="submit">Delete</button>
                            <a class="btn btn-warning btn-sm m-1">Edit</a>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-3">
                <p class="text-center text-secondary">No questions added.</p>
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