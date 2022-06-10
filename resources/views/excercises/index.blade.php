@extends('layouts.app')
@section('main')

<div class="container">
    <div class="row mt-4">
        <div class="col-4">
            <h4>Pre-listening excercises</h4>
            <ul class="list-group">
                @foreach($pre_listening_excercises as $pre_listening_excercise)
                <li class="list-group-item">{{ $pre_listening_excercise->name }}</li>
                @endforeach
                <li class="list-group-item">
                    <button type="button" id="selectExcerciseTypeModal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#selectExcerciseTypeModal">Add excercise</button>
                </li>
            </ul>
        </div>
        <div class="col-4">
            <h4>While-listening excercises</h4>
            <ul class="list-group">
                @foreach($while_listening_excercises as $while_listening_excercise)
                <li class="list-group-item">{{ $while_listening_excercise->name }}</li>
                @endforeach
                <li class="list-group-item"><a class="btn btn-primary">Add excercise</a>
            </ul>
        </div>
        <div class="col-4">
            <h4>Post-listening excercises</h4>
            <ul class="list-group">
                @foreach($post_listening_excercises as $post_listening_excercise)
                <li class="list-group-item">{{ $post_listening_excercise->name }}</li>
                @endforeach
                <li class="list-group-item"><a class="btn btn-primary">Add excercise</a>
            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectExcerciseTypeModal" tabindex="-1" aria-labelledby="selectExcerciseTypeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectExcerciseTypeModal">Edit Keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercise.create') }}" method="POST">
                    @csrf
                    <input id="word" name="word" type="text" class="form-control" placeholder="Enter keyword" value="{{ $keyword->keyword }}">
                    <br>
                    <select name="excercise_type" id="excercise_type">                        
                        <option value="open_answer">Open answer</option>
                        <option value="meet_characters">Meet the characters</option>
                        <option value="drag_and_drop">Drag and drop</option>
                        <option value="multiple_choice">Multiple choice</option>
                    </select>
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