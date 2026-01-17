@extends('layouts.app')
@section('main')

<div class="container mt-3">
    <div class="border rounded mb-3 p-3 d-flex justify-content-between">
        <h4>@if(isset($tracking->exercise->exerciseType->name)) {{ $tracking->exercise->exerciseType->name }} exercise tracking information @else Tracking Information @endif </h4>
        <a href="{{ route('tracking.index') }}" class="btn btn-link">Go back</a>
    </div>
    
    <h5>Exercise completion data</h5>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan=3><small class="text-secondary">Student info:</small></td>
            </tr>
            <tr>
                <td><strong>Student ID</strong></td>
                <td colspan=2>{{ $tracking->user->user_id }}</td>
            </tr>
            <tr>
                <td><strong>Group</strong></td>
                <td colspan=2>{{ $tracking->user->group->name }}</td>
            </tr>
            <tr>
                <td colspan=3><small class="text-secondary">Activity info:</small></td>
            </tr>
            <tr>
                <td><strong>Activity title</strong></td>
                <td colspan=2>{{ $tracking->exercise->title }}</td>
            </tr>
            <tr>
                <td><strong>Unit</strong></td>
                <td colspan=2>{{ $tracking->exercise->section->unit->title }}</td>
            </tr>
            <tr>
                <td><strong>Section</strong></td>
                <td colspan=2>{{ $tracking->exercise->section->name }}</td>
            </tr>
            <tr>
                <td colspan=3><small class="text-secondary">Response info:</small></td>
            </tr>
            <tr>
                <td><strong>Time spent</strong></td>
                <td colspan=2>{{ $tracking->formatted_time }}</td>
            </tr>
            <tr>
                <td><strong>Correct answers</strong></td>
                <td colspan=2>{{ $tracking->correct_answers }}</td>
            </tr>
            <tr>
                <td><strong>Wrong answers</strong></td>
                <td colspan=2>{{ $tracking->wrong_answers }}</td>
            </tr>
            <tr>
                <td><strong>Number of tries</strong></td>
                <td colspan=2>{{ $tracking->intent_number }}</td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td colspan=2>{{ date('d/m/Y - h:i:s', strtotime($tracking->created_at)); }}</td>
            </tr>
            <tr>
                <td colspan=3><small class="text-secondary">Help Options Interactions:</small></td>
            </tr>
            @if($tracking->helpUsage->count() > 0)
                <th>Name</th>
                <th>Interactions count</th>
                <th>Time spent</th>
                @foreach($tracking->helpUsage as $helpUsage)
                    <tr>
                        <td>{{ $helpUsage->help_type }}</td>
                        <td>{{ $helpUsage->open_count }}</td>
                        <td>{{ $helpUsage->formatted_time }}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan=3><small class="text-secondary">Question responses:</small></td>
            </tr>
            @php $type = $tracking->exercise->exerciseType->underscore_name; @endphp
            @if($type == 'form')
                @foreach($tracking->exercise->questions as $question)
                    @php $q_n = $loop->index + 1; @endphp
                    <th colspan=3><p class="text-center">Question number {{ $q_n }}</p></th>
                    <tr>
                        <td><strong>Response</strong></td>
                        <td colspan=2>
                            <ul>
                                @foreach($tracking->userResponses->where('question_id', $question->id) as $response)
                                    <li>{{ $response->response }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @if($tracking->feedbackUsage->count() > 0)
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($tracking->feedbackUsage as $feedbackUsage)
                            <tr>
                                <td>{{ $feedbackUsage->feedback_type }}</td>
                                <td colspan=2>{{ $feedbackUsage->open_count }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @elseif($type == 'multiple_choice')
                @forelse($tracking->userResponses as $response)
                    @php $q_n = $loop->index + 1; @endphp
                    <th colspan=3><p class="text-center">Question number {{ $q_n }}</p></th>
                    <tr>
                        <td><strong>Response</strong></td>
                        <td colspan=2>{{ $response->response }}</td>
                    </tr>
                    @if($tracking->feedbackUsage->count() > 0)
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($tracking->feedbackUsage as $feedbackUsage)
                            <tr>
                                <td>{{ $feedbackUsage->feedback_type }}</td>
                                <td colspan=2>{{ $feedbackUsage->open_count }}</td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            @elseif($type == 'drag_and_drop')
                @forelse($tracking->userResponses as $response)
                    @php $q_n = $loop->index + 1; @endphp
                    <th colspan=3><p class="text-center">Question number {{ $q_n }}</p></th>
                    <tr>
                        <td><strong>Response</strong></td>
                        <td colspan=2>{{ $response->response }}</td>
                    </tr>
                    @if($tracking->feedbackUsage->count() > 0)
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($tracking->feedbackUsage as $feedbackUsage)
                            <tr>
                                <td>{{ $feedbackUsage->feedback_type }}</td>
                                <td colspan=2>{{ $feedbackUsage->open_count }}</td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            @else
                @forelse($tracking->userResponses as $response)
                    @php $q_n = $loop->index + 1; @endphp
                    <th colspan=3><p class="text-center">Question number {{ $q_n }}</p></th>
                    <tr>
                        <td><strong>Response</strong></td>
                        <td colspan=2>{{ $response->response }}</td>
                    </tr>
                    @if($tracking->feedbackUsage->count() > 0)
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($tracking->feedbackUsage as $feedbackUsage)
                            <tr>
                                <td>{{ $feedbackUsage->feedback_type }}</td>
                                <td colspan=2>{{ $feedbackUsage->open_count }}</td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            @endif
        </tbody>
    </table>
</div>

@endsection