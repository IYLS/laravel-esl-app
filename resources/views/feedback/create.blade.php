@extends('layouts.app')
@section('main')

<div class="container mt-4">
    <div class="d-flex justify-content-between mt-2 p-2">
        <h3>Feedback Settings</h3>
        <a class="btn btn-link" href="{{ route('exercises.show', $exercise->id) }}">Go back</a>
    </div>
    <div class="p-2">
        <h6>Title: {{ $exercise->title }}</h6>
        <h6>Description: {!! $exercise->description == "" ? "<small class='text-secondary'>empty</small>" : $exercise->description !!}</h6>
    </div>
    <div class="card m-2">
        <p class="text-info text-center"><i class="mdi mdi-information-outline"></i><small>Use blue buttons to get more info about the input to provide.</small></p>
    </div>
    <div class="p-2 ps-2 pe-2 col-12 col-md-12">

        <form action="{{ route('feedback.store', $exercise->id) }}" method="POST">
            @csrf
            
            @foreach($feedback_types as $type)
                @if($type->level == 'exercise')
                    @if($type->text_based)
                        <div class=" row mb-1">
                            <div class="col-12 col-md-8 d-flex justify-content-center">
                                <input type="text" class="form-control me-1" name="data[exercise][{{ $type->id }}][message]" required placeholder="{{ $type->name }}">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                    <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $type->description }}"></i>
                                </button>
                                @include('exercises.modals.feedback_description', ['type' => "$type->name", 'description' => "$type->description", 'id' => "$type->id"])
                            </div>
                        </div>
                    @endif
                @elseif($type->level == 'question')
                    @foreach($exercise->questions as $question)
                        @if($type->text_based and $type->id == 5)
                            @if($exercise->exercise_type_id == 2 and $exercise->subtype == 1)
                                <ol type="I"> @foreach(explode(";", $question->statement) as $st) <li><p>{{ $st }}</p></li>@endforeach</ol>
                            @else
                                <h5>{{ $loop->index + 1 . ". " . $question->statement }}</h5>
                            @endif
                            @foreach($question->alternatives as $alternative)
                                <div class=" row mb-1">
                                    <div class="col-12 col-md-8 d-flex justify-content-center">
                                        <input type="text" class="form-control me-1" name="data[question][{{ $type->id }}][{{ $question->id }}][{{ $alternative->id }}][message]" required placeholder="{{ $type->name }}">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                            <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $type->description }}"></i>
                                        </button>
                                        @include('exercises.modals.feedback_description', ['type' => "$type->name", 'description' => "$type->description", 'id' => "$type->id"])
                                    </div>
                                </div>
                            @endforeach
                        @elseif($type->text_based)
                            <div class=" row mb-1">
                                <div class="col-12 col-md-8 d-flex justify-content-center">
                                    <input type="text" class="form-control me-1" name="data[question][{{ $type->id }}][{{ $question->id }}][message]" required placeholder="{{ $type->name }}">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                        <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $type->description }}"></i>
                                    </button>
                                    @include('exercises.modals.feedback_description', ['type' => "$type->name", 'description' => "$type->description", 'id' => "$type->id"])
                                </div>
                            </div>
                        @elseif(!$type->text_based)
                            <div class=" row mb-1">
                                <div class="col-12 col-md-8 d-flex justify-content-center">
                                    <label for="audio" class="form-label">Select audio file</label>
                                </div>
                                <div class="col-12 col-md-8 d-flex justify-content-center">
                                    <input class="form-control" type="file" id="audio" accept="audio/*" name="data[question][{{ $type->id }}][{{ $question->id }}][audio]" required>
                                    <button class="btn btn-primary ms-1" type="button" data-bs-toggle="modal" data-bs-target="#feedback_description_{{ $type->id }}_modal">
                                        <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $type->description }}"></i>
                                    </button>
                                    @include('exercises.modals.feedback_description', ['type' => "$type->name", 'description' => "$type->description", 'id' => "$type->id"])
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            @endforeach

            <button class="btn btn-primary" type="submit">
                Save
            </button>
        </form>

    </div>
</div>

@endsection