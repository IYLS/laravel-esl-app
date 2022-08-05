@extends('layouts.app')
@section('main')

<div class="container">
    <div class="card p-4 m-4 shadow border-0">
        <div class="row">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4>Pre-listening</h4>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th>Activity title</th>
                <th>Description</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($pre_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-8">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            <a href="#" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                            <a href="#" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="addPreListeningExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningExcerciseModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New Pre-Listening activity</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('excercises.' .$excercise->type .'.store', [$unit_id, $excercise->section]) }}" method="POST">
                                        @csrf
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Title">
                                        <br>
                                        <input id="description" name="description" type="text" class="form-control" placeholder="Description">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td>
                            <p class="text-secondary">Nothing yet</p>  
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5 d-flex justify-content-around">
            <h5>Add excercises:</h5>
            <div><button type="button" id="addDragAndDropButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addOpenEndedButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addMultipleChoiceButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addVoiceRecognitionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addFillInTheGapsButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningExcerciseModal">Fill-in The Gaps</button></div>
        </div>
    </div>

    <div class="card p-4 m-4 shadow border-0">
        <div class="row">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4>While-listening</h4>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th>Activity title</th>
                <th>Description</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($while_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-8">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            <a href="#" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                            <a href="#" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="addWhileListeningExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningExcerciseModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New While-Listening activity</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('excercises.' .$excercise->type .'.store', [$unit_id, $excercise->section]) }}" method="POST">
                                        @csrf
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Title">
                                        <br>
                                        <input id="description" name="description" type="text" class="form-control" placeholder="Description">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td>
                            <p class="text-secondary">Nothing yet</p>  
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5 d-flex justify-content-around">
            <h5>Add excercises:</h5>
            <div><button type="button" id="addDragAndDropWhileListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addOpenEndedWhileListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addMultipleChoiceWhileListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addVoiceRecognitionWhileListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addFillInWithGapsWhileListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningExcerciseModal">Fill-in The Gaps</button></div>
        </div>
    </div>

    <div class="card p-4 m-4 shadow border-0">
        <div class="row">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4>Post-listening</h4>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th>Activity title</th>
                <th>Description</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($post_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-8">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            <a href="#" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                            <a href="#" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="addPostListeningExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningExcerciseModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostListeningExcerciseModal">New Post-Listening activity</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('excercises.' .$excercise->type .'.store', [$unit_id, $excercise->section]) }}" method="POST">
                                        @csrf
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Title">
                                        <br>
                                        <input id="description" name="description" type="text" class="form-control" placeholder="Description">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td>
                            <p class="text-secondary">Nothing yet</p>  
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5 d-flex justify-content-around">
            <h5>Add excercises:</h5>
            <div><button type="button" id="addDragAndDropPostListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addOpenEndedPostListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addMultipleChoicePostListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addVoiceRecognitionPostListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addFillInTheGapsListeningExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningExcerciseModal">Fill-in The Gaps</button></div>
        </div>
    </div>
</div>

@endsection