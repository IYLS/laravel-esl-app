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
                <td colspan=2>{{ $tracking->time_spent_in_minutes }}</td>
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
                <th>Name</th>
                <th>Interactions count</th>
                <th>Time spent</th>
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
                    @if(isset($tracking->feedback))
                        @php
                        $items = explode(';', $tracking->feedback);
                        $questions_count = count($items);
                        @endphp
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($items as $question_data)
                            @php 
                            $question_number = explode(':', $question_data)[0];
                            $feedback_content = explode(':', $question_data)[1];
                            $content = explode(",", $feedback_content);
                            @endphp

                            @if($question_number == $q_n)
                                @foreach($content as $type)
                                    @php 
                                        $name = explode("~", $type)[0];
                                        $count = explode("~", $type)[1];
                                    @endphp
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td colspan=2>{{ $count }}</td>
                                    </tr>
                                @endforeach
                            @endif
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
                    @if(isset($tracking->feedback))
                        @php
                        $items = explode(';', $tracking->feedback);
                        $questions_count = count($items);
                        @endphp
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($items as $question_data)
                            @php 
                            $question_number = explode(':', $question_data)[0];
                            $feedback_content = explode(':', $question_data)[1];
                            $content = explode(",", $feedback_content);
                            @endphp

                            @if($question_number == $q_n)
                                @foreach($content as $type)
                                    @php 
                                        $name = explode("~", $type)[0];
                                        $count = explode("~", $type)[1];
                                    @endphp
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td colspan=2>{{ $count }}</td>
                                    </tr>
                                @endforeach
                            @endif
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
                    @if(isset($tracking->feedback))
                        @php
                        $items = explode(';', $tracking->feedback);
                        $questions_count = count($items);
                        @endphp
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($items as $question_data)
                            @php 
                            $question_number = explode(':', $question_data)[0];
                            $feedback_content = explode(':', $question_data)[1];
                            $content = explode(",", $feedback_content);
                            @endphp

                            @if($question_number == $q_n)
                                @foreach($content as $type)
                                    @php 
                                        $name = explode("~", $type)[0];
                                        $count = explode("~", $type)[1];
                                    @endphp
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td colspan=2>{{ $count }}</td>
                                    </tr>
                                @endforeach
                            @endif
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
                    @if(isset($tracking->feedback))
                        @php
                        $items = explode(';', $tracking->feedback);
                        $questions_count = count($items);
                        @endphp
                        <tr>
                            <td colspan="3"><small class="text-secondary">Feedback Interactions:</small></td>
                        </tr>
                        <th>Name</th>
                        <th colspan=2>Interactions count</th>
                        @foreach($items as $question_data)
                            @php 
                            $question_number = explode(':', $question_data)[0];
                            $feedback_content = explode(':', $question_data)[1];
                            $content = explode(",", $feedback_content);
                            @endphp

                            @if($question_number == $q_n)
                                @foreach($content as $type)
                                    @php 
                                        $name = explode("~", $type)[0];
                                        $count = explode("~", $type)[1];
                                    @endphp
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td colspan=2>{{ $count }}</td>
                                    </tr>
                                @endforeach
                            @endif
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