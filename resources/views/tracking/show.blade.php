@extends('layouts.app')
@section('main')

<div class="container mt-3">
    <div class="border rounded ms-2 me-2 mb-2 p-2 d-flex justify-content-between">
        <h4>@if(isset($tracking->exercise->exerciseType->name)) {{ $tracking->exercise->exerciseType->name }} exercise tracking information @else Tracking Information @endif </h4>
        <a href="{{ route('tracking.index') }}" class="btn btn-link">Go back</a>
    </div>
    
    <div class="p-3">
        <h5>Exercise completion data</h5>
        <div class="p-3 mb-2 border rounded">
            <p class="text-secondary"><small>Student Info:</small></p>
            <ul>
                <li>ID: {{ $tracking->user->user_id }}</li>
                <li>Name: {{ $tracking->user->name }}</li>
                <li>Group: {{ $tracking->user->group->name }}</li>
                <li>E-mail: {{ $tracking->user->email }}</li>
            </ul>

            <p class="text-secondary"><small>Exercise Info:</small></p>
            <ul>
                @if(isset($tracking->exercise)) <li>Exercise ID: {{ $tracking->exercise->id }}</li> @endif
                <li>Exercise Name: {{ $tracking->exercise->title }}</li>
                <li>Unit: {{ $tracking->exercise->section->unit->title }}</li>
                <li>Section: {{ $tracking->exercise->section->name }}</li>
            </ul>

            <p class="text-secondary"><small>Results:</small></p>
            <ul>
                <li>Time spent (minutes): {{ $tracking->time_spent_in_minutes }}</li>
                <li>Number of correct answers: {{ $tracking->correct_answers }}</li>
                <li>Number of wrong answers: {{ $tracking->wrong_answers }}</li>
                <li>Number of tries: {{ $tracking->intent_number }}</li>
                <li>Date: {{ $tracking->created_at }}</li>
            </ul>
        </div>
    </div>

    <div class="p-3">
        <h5>Questions details</h5>
        @php $type = $tracking->exercise->exerciseType->underscore_name; @endphp
        @if($type == 'form')
            <div class="p-3 mb-2 border rounded">
                @foreach($tracking->exercise->questions as $question)
                    <h5>{{ $loop->index+1 . ". " . $question->correct_answer }}</h5>

                    <ul>
                        @foreach($tracking->userResponses->where('question_id', $question->id) as $response)
                            <li>
                                <p>{{ $response->response }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        @elseif($type == 'multiple_choice')
            <div class="p-3 mb-2 border rounded">
                @forelse($tracking->userResponses as $response)
                    <h5>{{ $loop->index + 1 . ". " }} {{ $response->question->statement }}</h5>
                    <p>User response: {{ $response->response }}</p>
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            </div>
        @elseif($type == 'drag_and_drop')
            <div class="p-3 mb-2 border rounded">
                @forelse($tracking->userResponses as $response)
                    <h5>{{ $loop->index + 1 . ". " }} {{ $response->question->answer }}</h5>
                    <p>User response: {{ $response->response }}</p>
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            </div>
        @else
            <div class="p-3 mb-2 border rounded">
                @forelse($tracking->userResponses as $response)
                    <h5>{{ $loop->index + 1 . ". " }} {{ $response->question->statement }}</h5>
                    <p>User response: {{ $response->response }}</p>
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            </div>
        @endif
    </div>
</div>

@endsection