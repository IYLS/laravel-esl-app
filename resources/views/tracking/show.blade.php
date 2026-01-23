@extends('layouts.app')
@section('main')

<div class="container mt-3">
    <div class="border rounded mb-3 p-3 d-flex justify-content-between">
        <h4>@if(isset($tracking->exercise->exerciseType->name)) {{ $tracking->exercise->exerciseType->name }} exercise tracking information @else Tracking Information @endif </h4>
        @php
            $backUrl = route('tracking.index');
            $queryParams = [];
            if (isset($group_id) && $group_id && $group_id != 'any') {
                $queryParams['group'] = $group_id;
            }
            if (isset($user_id) && $user_id && $user_id != 'any') {
                $queryParams['student'] = $user_id;
            }
            if (!empty($queryParams)) {
                $backUrl .= '?' . http_build_query($queryParams);
            }
        @endphp
        <a href="{{ $backUrl }}" class="btn btn-link">Go back</a>
    </div>
    
    <h5>Exercise completion data</h5>
    <table class="table table-bordered">
        <tbody>
            @include('components.table-section-header', ['title' => 'Student info'])
            <tr>
                <td><strong>Student ID</strong></td>
                <td colspan=2>{{ $tracking->user->user_id }}</td>
            </tr>
            <tr>
                <td><strong>Group</strong></td>
                <td colspan=2>{{ $tracking->user->group->name }}</td>
            </tr>
            @include('components.table-section-header', ['title' => 'Activity info'])
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
            @include('components.table-section-header', ['title' => 'Response info'])
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
            @include('components.table-section-header', ['title' => 'Help Options Interactions'])
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
            @include('components.table-section-header', ['title' => 'Question responses'])
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
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $tracking->feedbackUsage])
                @endforeach
            @elseif($type == 'multiple_choice')
                @forelse($tracking->userResponses as $response)
                    @php $q_n = $loop->index + 1; @endphp
                    <th colspan=3><p class="text-center">Question number {{ $q_n }}</p></th>
                    <tr>
                        <td><strong>Response</strong></td>
                        <td colspan=2>{{ $response->response }}</td>
                    </tr>
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $tracking->feedbackUsage])
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
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $tracking->feedbackUsage])
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
                    @include('components.feedback-interactions-table', ['feedbackUsage' => $tracking->feedbackUsage])
                @empty
                    <p class="text-secondary text-center"><small>Empty</small></p>
                @endforelse
            @endif
        </tbody>
    </table>
</div>

@endsection