@extends('layouts.app')
@section('main')

<div class="container">
    <div class="mt-2 p-2">
        <h2>Multiple Choice questions activity</h2>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity Details</h4>
        <p>Title: {{ $excercise->title }}</p>
        <p>Description: {{ $excercise->description }}</p>
        <p>Subtype: {{ $excercise->subtype }}</p>
    </div>

    <div class="card p-4 m-2">
        <h4>Activity questions</h4>
        @forelse($excercise->questions as $question)
            @if($excercise->subtype == 1 || $excercise->subtype == 4)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
                            <p>Statements</p>
                            <ol type="I">
                                @php 
                                    $statements = explode(";", $question->statement);
                                @endphp
                                @foreach($statements as $statement)
                                <li>
                                    {{ $statement }}
                                </li>
                                @endforeach
                            </ol>
                            <p>Alternatives</p>
                            <ol type="a">
                                @foreach($question->alternatives as $alt)
                                <li>{{ $alt->title }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <form action="{{ route('questions.destroy', [$question->excercise_id, $question->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm m-1" type="submit">Delete</button>
                                <a class="btn btn-warning btn-sm m-1">Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($excercise->subtype == 2)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
                            @php 
                                $statements = explode(";;", $question->statement);
                                $alternatives = $question->alternatives
                            @endphp
                            <div class="d-flex">
                                <p>{{ $loop->index + 1 }}. &nbsp;</p>
                                <p>{{ $statements[0] }}</p>
                                <p class="text-primary">&nbsp;
                                    @if($alternatives[0]->correct_alt == true)
                                        <strong>{{ $alternatives[0]->title }}</strong>
                                        /
                                        {{ $alternatives[1]->title }}
                                    @elseif($alternatives[1]->correct_alt == true)
                                        {{ $alternatives[0]->title }}
                                        /
                                        <strong>{{ $alternatives[1]->title }}</strong>
                                    @endif
                                    &nbsp;
                                </p>
                                <p>{{ $statements[1] }}</p>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <form action="{{ route('questions.destroy', [$question->excercise_id, $question->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm m-1" type="submit">Delete</button>
                                <a class="btn btn-warning btn-sm m-1">Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($excercise->subtype == 3)
                <div class="card mt-1 mb-1 p-4">
                    <div class="row">
                        <div class="col-10">
                            <p>Statement:</p>
                            <ul>
                                <li>
                                    <p>{{ $question->statement }}</p>
                                </li>
                            </ul>
                            <p>Correct answer:</p>
                            <ul>
                                <li>
                                    <p class="text-primary"><strong>True</strong></p>
                                </li>
                                <li>
                                    <p>False</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <form action="{{ route('questions.destroy', [$question->excercise_id, $question->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm m-1" type="submit">Delete</button>
                                <a class="btn btn-warning btn-sm m-1">Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
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