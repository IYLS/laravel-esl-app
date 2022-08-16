@extends('layouts.app')
@section('main')

<div class="container">
    <div class="m-2">
        <h2>{{ $unit_name . " Unit" }}</h2>
    </div>
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
                <th>Type</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($pre_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-6">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            @php $excercise_type = str_replace('_', ' ', $excercise->type) @endphp
                            {{ $excercise_type }}
                        </td>
                        <td class="col-2">
                            <form action="{{ route("excercises.$excercise->type.destroy", [$unit_id, $excercise->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                            </form>

                            <a href="{{ route("excercises.$excercise->type.create", [$unit_id, $excercise->section_id, $excercise->id]) }}" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                        </td>
                    </tr>
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
            <div><button type="button" id="addPreListeningDragAndDropButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningDragAndDropExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addPreListeningOpenEndedButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningOpenEndedExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addPreListeningMultipleChoiceButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningMultipleChoiceExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addPreListeningVoiceRecognitionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningVoiceRecognitionExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addPreListeningFillInTheGapsButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningFillInTheGapsExcerciseModal">Fill-in The Gaps</button></div>
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
                <th>Type</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($while_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-6">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            @php $excercise_type = str_replace('_', ' ', $excercise->type) @endphp
                            {{ $excercise_type }}
                        </td>
                        <td class="col-2">
                            <form action="{{ route("excercises.$excercise->type.destroy", [$unit_id, $excercise->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                            </form>

                            <a href="{{ route("excercises.$excercise->type.create", [$unit_id, $excercise->section_id, $excercise->id]) }}" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                        </td>
                    </tr>
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
            <div><button type="button" id="addWhileListeningDragAndDropButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningDragAndDropExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addWhileListeningOpenEndedButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningOpenEndedExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addWhileListeningMultipleChoiceButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningMultipleChoiceExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addWhileListeningVoiceRecognitionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningVoiceRecognitionExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addWhileListeningFillInTheGapsButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhileListeningFillInTheGapsExcerciseModal">Fill-in The Gaps</button></div>
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
                <th>Type</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @forelse($post_listening_excercises as $excercise)
                    <tr>
                        <td class="col-2">
                            {{ $excercise->title }}
                        </td>
                        <td class="col-6">
                            {{ $excercise->description }}
                        </td>
                        <td class="col-2">
                            @php $excercise_type = str_replace('_', ' ', $excercise->type) @endphp
                            {{ $excercise_type }}
                        </td>
                        <td class="col-2">
                            <form action="{{ route("excercises.$excercise->type.destroy", [$unit_id, $excercise->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                            </form>

                            <a href="{{ route("excercises.$excercise->type.create", [$unit_id, $excercise->section_id, $excercise->id]) }}" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
                        </td>
                    </tr>
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
            <div><button type="button" id="addPostListeningDragAndDropButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningDragAndDropExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addPostListeningOpenEndedutton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningOpenEndedExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addPostListeningMultipleChoiceButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningMultipleChoiceExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addPostListeningVoiceRecognitionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningVoiceRecognitionExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addPostListeningFillInTheGapsButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostListeningFillInTheGapsExcerciseModal">Fill-in The Gaps</button></div>
        </div>
    </div>
</div>

{{-- Pre listening modals --}}
<!-- Drag and Drop Modal -->
<div class="modal fade" id="addPreListeningDragAndDropExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningDragAndDropExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Drag and Drop activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.drag_and_drop.store', [$unit_id, 'pre_listening']) }}" method="POST">
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

<!-- Open ended modal -->
<div class="modal fade" id="addPreListeningOpenEndedExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningOpenEndedExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Open Ended activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.open_ended.store', [$unit_id, 'pre_listening']) }}" method="POST">
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

<!-- Multiple choice modal -->
<div class="modal fade" id="addPreListeningMultipleChoiceExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningMultipleChoiceExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Multiple Choice activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.multiple_choice.store', [$unit_id, 'pre_listening']) }}" method="POST">
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

<!-- Voice Recognition odal -->
<div class="modal fade" id="addPreListeningVoiceRecognitionExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningVoiceRecognitionExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.voice_recognition.store', [$unit_id, 'pre_listening']) }}" method="POST">
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

<!-- Fill-in the Gaps odal -->
<div class="modal fade" id="addPreListeningFillInTheGapsExcerciseModal" tabindex="-1" aria-labelledby="addPreListeningFillInTheGapsExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.fill_in_the_gaps.store', [$unit_id, 'pre_listening']) }}" method="POST">
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

{{-- While listening modals --}}
<!-- Drag and Drop Modal -->
<div class="modal fade" id="addWhileListeningDragAndDropExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningDragAndDropExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Drag and Drop activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.drag_and_drop.store', [$unit_id, 'while_listening']) }}" method="POST">
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

<!-- Open ended odal -->
<div class="modal fade" id="addWhileListeningOpenEndedExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningOpenEndedExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Open Ended activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.open_ended.store', [$unit_id, 'while_listening']) }}" method="POST">
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

<!-- Multiple choice modal -->
<div class="modal fade" id="addWhileListeningMultipleChoiceChoiceExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningMultipleChoiceChoiceExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Multiple Choice activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.multiple_choice.store', [$unit_id, 'while_listening']) }}" method="POST">
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

<!-- Voice Recognition odal -->
<div class="modal fade" id="addWhileListeningVoiceRecognitionExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningVoiceRecognitionExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.voice_recognition.store', [$unit_id, 'while_listening']) }}" method="POST">
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

<!-- Fill-in the Gaps modal -->
<div class="modal fade" id="addWhileListeningFillInTheGapsExcerciseModal" tabindex="-1" aria-labelledby="addWhileListeningFillInTheGapsExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.fill_in_the_gaps.store', [$unit_id, 'while_listening']) }}" method="POST">
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

{{-- Post listening modals --}}
<!-- Drag and Drop Modal -->
<div class="modal fade" id="addPostListeningDragAndDropExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningDragAndDropExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Drag and Drop activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.drag_and_drop.store', [$unit_id, 'post_listening']) }}" method="POST">
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

<!-- Open ended odal -->
<div class="modal fade" id="addPostListeningOpenEndedExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningOpenEndedExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Open Ended activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.open_ended.store', [$unit_id, 'post_listening']) }}" method="POST">
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

<!-- Multiple choice modal -->
<div class="modal fade" id="addPostListeningMultipleChoiceChoiceExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningMultipleChoiceChoiceExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Multiple Choice activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.multiple_choice.store', [$unit_id, 'post_listening']) }}" method="POST">
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

<!-- Voice Recognition odal -->
<div class="modal fade" id="addPostListeningVoiceRecognitionExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningVoiceRecognitionExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.voice_recognition.store', [$unit_id, 'post_listening']) }}" method="POST">
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

<!-- Fill-in the Gaps odal -->
<div class="modal fade" id="addPostListeningFillInTheGapsExcerciseModal" tabindex="-1" aria-labelledby="addPostListeningFillInTheGapsExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.fill_in_the_gaps.store', [$unit_id, 'post_listening']) }}" method="POST">
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

@endsection