@extends('layouts.app')
@section('main')

<div class="container mt-3">
    <div class="border rounded ms-2 me-2 mb-2 p-2 d-flex justify-content-between">
        <h4>{{ $tracking->exercise->exerciseType->name . " exercise tracking information"}}</h4>
        <a href="{{ route('tracking.index') }}" class="btn btn-link">Go back</a>
    </div>

    <div class="p-3">
        <h5>Exercise completion data</h5>
        <div class="p-3 mb-2 border rounded">
            <p>Exercise Id: {{ $tracking->exercise->id }}</p>
            <p>Time spent (minutes): {{ $tracking->time_spent_in_minutes }}</p>
            <p>Number of correct answers: {{ $tracking->correct_answers }}</p>
            <p>Number of wrong answers: {{ $tracking->wrong_answers }}</p>
            <p>Number of tries: {{ $tracking->intent_number }}</p>
        </div>
    </div>

    <div class="p-3">
        <h5>Questions info</h5>
            @forelse($tracking->responses as $response)
                <div class="p-3 mb-2 border rounded">
                    <h5>{{ $loop->index + 1 . ". " }} Title: {{ $response->question->statement }}</h5>
                    <p>User response: {{ $response->response }}</p>
                    <p>Date: {{ $tracking->created_at }}</p>
                </div>
            @empty
            @endforelse
    </div>
</div>

@endsection