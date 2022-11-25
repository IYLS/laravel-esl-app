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
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan=2><small class="text-secondary">Student info:</small></td>
                    </tr>
                    <tr>
                        <td><strong>Student ID</strong></td>
                        <td>{{ $tracking->user->user_id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Group</strong></td>
                        <td>{{ $tracking->user->group->name }}</td>
                    </tr>
                    <tr>
                        <td colspan=2><small class="text-secondary">Activity info:</small></td>
                    </tr>
                    <tr>
                        <td><strong>Activity title</strong></td>
                        <td>{{ $tracking->exercise->title }}</td>
                    </tr>
                    <tr>
                        <td><strong>Unit</strong></td>
                        <td>{{ $tracking->exercise->section->unit->title }}</td>
                    </tr>
                    <tr>
                        <td><strong>Section</strong></td>
                        <td>{{ $tracking->exercise->section->name }}</td>
                    </tr>
                    <tr>
                        <td colspan=2><small class="text-secondary">Response info:</small></td>
                    </tr>
                    <tr>
                        <td><strong>Time spent</strong></td>
                        <td>{{ $tracking->time_spent_in_minutes }}</td>
                    </tr>
                    <tr>
                        <td><strong>Correct answers</strong></td>
                        <td>{{ $tracking->correct_answers }}</td>
                    </tr>
                    <tr>
                        <td><strong>Wrong answers</strong></td>
                        <td>{{ $tracking->wrong_answers }}</td>
                    </tr>
                    <tr>
                        <td><strong>Number of tries</strong></td>
                        <td>{{ $tracking->intent_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date</strong></td>
                        <td>{{ date('d/m/Y ~ h:m', strtotime($tracking->created_at)); }}</td>
                    </tr>
                </tbody>
            </table>

            <br>

            @if(isset($tracking->help_options))
                @php
                $s = explode(',', $tracking->help_options);
            
                $dictionary = $s[5];
                $transcript = $s[0];
                $tips = $s[1];
                $cultural = $s[2];
                $glossary = $s[3];
                $translation = $s[4];
                @endphp
                <p class="text-secondary"><small>Help Options:</small></p>
                <table class="table table-bordered">
                    <thead>
                        <th>Name</th>
                        <th>Interactions count</th>
                        <th>Time spent</th>
                    </thead>
                    <tbody>
                        @foreach($s as $i)
                            @php 
                                $i_array = explode("~", $i);

                                $name = $i_array[0];
                                $interactions = $i_array[1];
                                $time = $i_array[2];
                            @endphp
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $interactions }}</td>
                                <td>{{ $time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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