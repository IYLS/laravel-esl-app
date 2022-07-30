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
                <tr>
                    <td class="col-2">
                        Meet the characters
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td class="col-2">
                        What do you hear?
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button type="button" id="addExcerciseButton2" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningModal">Add activity</button>
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
                <tr>
                    <td class="col-2">
                        Meet the characters
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td class="col-2">
                        What do you hear?
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button type="button" id="addExcerciseButton1" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningModal">Add activity</button>
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
                <tr>
                    <td class="col-2">
                        Meet the characters
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td class="col-2">
                        What do you hear?
                    </td>
                    <td class="col-8">
                        The student must listen the audio and check the image
                    </td>
                    <td class="col-2">
                        <a href="#" class="btn btn-success"><i class="mdi mdi-magnify"
                            aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-danger"><i class="mdi mdi-delete"
                            aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button type="button" id="addExcerciseButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningModal">Add activity</button>
        </div>
    </div>
</div>

<!-- PRE LISTENING -->
<div class="modal fade" id="addPreListeningModal" tabindex="-1" aria-labelledby="addPreListeningModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPreListeningModal">Select type of excercise to add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                </select>
                <div class="modal-footer">
                    <a type="submit" href="{{ route('excercises.voice_recognition.create', $unit_id) }}" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WHILE LISTENING -->
<div class="modal fade" id="addWhileListeningModal" tabindex="-1" aria-labelledby="addWhileListeningModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWhileListeningModal">Select type of excercise to add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example">

                </select>
                <div class="modal-footer">
                    <a type="submit" href="{{ route('excercises.voice_recognition.create', $unit_id) }}" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- POST LISTENING -->
<div class="modal fade" id="addPostListeningModal" tabindex="-1" aria-labelledby="addPostListeningModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostListeningModal">Select type of excercise to add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example">

                </select>
                <div class="modal-footer">
                    <a type="submit" href="{{ route('excercises.voice_recognition.create', $unit_id) }}" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection