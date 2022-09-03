@extends('layouts.app')
@section('main')

<div class="container">
    <div class="m-2">
        <h2>{{ $unit->title . " Unit" }}</h2>
    </div>
    @foreach($unit->sections as $section)
    <div class="card p-4 m-4 shadow border-0">
        <div class="row">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4>{{ $section->name }}</h4>
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
                @forelse($section->excercises as $excercise)
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
                            <form action="{{ route("excercises.$excercise->type.destroy", [$unit->id, $excercise->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete" aria-hidden="true"></i></button>
                            </form>

                            <a href="{{ route("excercises.$excercise->type.create", [$unit->id, $excercise->section_id, $excercise->id]) }}" class="btn btn-success"><i class="mdi mdi-magnify" aria-hidden="true"></i></a>
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
            <div><button type="button" id="addPreListeningDragAndDropButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDragAndDropExcerciseModal">Drag and Drop</button></div>
            <div><button type="button" id="addPreListeningOpenEndedButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOpenEndedExcerciseModal">Open Ended</button></div>
            <div><button type="button" id="addPreListeningMultipleChoiceButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMultipleChoiceExcerciseModal">Multiple Choice</button></div>
            <div><button type="button" id="addPreListeningVoiceRecognitionButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVoiceRecognitionExcerciseModal">Voice Recognition</button></div>
            <div><button type="button" id="addPreListeningFillInTheGapsButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreListeningFillInTheGapsExcerciseModal">Fill-in The Gaps</button></div>
        </div>
    </div>
    @endforeach

</div>

{{-- Pre listening modals --}}
<!-- Drag and Drop Modal -->
<div class="modal fade" id="addDragAndDropExcerciseModal" tabindex="-1" aria-labelledby="addDragAndDropExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Drag and Drop activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.drag_and_drop.store', [$unit->id, 'pre_listening']) }}" method="POST">
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
<div class="modal fade" id="addOpenEndedExcerciseModal" tabindex="-1" aria-labelledby="addOpenEndedExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Open Ended activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.open_ended.store', [$unit->id, 'pre_listening']) }}" method="POST">
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
<div class="modal fade" id="addMultipleChoiceExcerciseModal" tabindex="-1" aria-labelledby="addMultipleChoiceExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Multiple Choice activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.multiple_choice.store', [$unit->id, 'pre_listening']) }}" method="POST">
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
<div class="modal fade" id="addVoiceRecognitionExcerciseModal" tabindex="-1" aria-labelledby="addVoiceRecognitionExcerciseModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Voice Recognition activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('excercises.voice_recognition.store', [$unit->id, 'pre_listening']) }}" method="POST">
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
                <form action="{{ route('excercises.fill_in_the_gaps.store', [$unit->id, 'pre_listening']) }}" method="POST">
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